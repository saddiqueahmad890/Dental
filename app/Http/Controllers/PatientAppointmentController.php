<?php

namespace App\Http\Controllers;

use App\Mail\NewAppointment;
use App\Mail\NewUserCredential;
use App\Models\Event;
use App\Models\DoctorSchedule;
use App\Models\PatientAppointment;
use App\Models\User;
use App\Models\UserLogs;
use App\Models\DoctorDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use App\Models\AppointmentStatus;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Mail\DoctorAppointmentReminder;

use App\Mail\AppointmentReminder;

class PatientAppointmentController extends Controller
{
    /**
     * Constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('permission:patient-appointment-read|patient-appointment-create|patient-appointment-update|patient-appointment-delete', ['only' => ['index', 'show', 'getAppointmentDoctorWise']]);
        $this->middleware('permission:patient-appointment-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:patient-appointment-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:patient-appointment-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Check if 'userid' is present in the request
        if ($request->has('userid')) {
            // Filter appointments by the doctor ID
            $patientAppointments = $this->filter($request)->where('doctor_id', $request->userid)
                ->paginate(10);
        } else {
            // Default behavior if no doctor ID is provided
            $patientAppointments = $this->filter($request)->orderBy('id', 'desc')->paginate(10);
        }

        // Get the list of doctors and patients
        $doctors = User::role('Doctor')->where('status', '1')->get(['id', 'name']);
        $patients = User::role('Patient')->where('status', '1')->get(['id', 'name']);

        return view('patient-appointment.index', compact('patientAppointments', 'patients', 'doctors'));
    }

    /**
     * Filter function
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    private function filter(Request $request)
    {
        $query = PatientAppointment::query();

        if (auth()->user()->hasRole('Doctor')) {
            $query->where('doctor_id', auth()->id());
        } elseif ($request->doctor_id) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if (auth()->user()->hasRole('Patient')) {
            $query->where('user_id', auth()->id());
        } elseif ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->appointment_date) {
            $query->where('appointment_date', $request->appointment_date);
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('appointment_date', [$request->start_date , $request->end_date]);
        } elseif ($request->start_date) {
            $query->where('appointment_date', '>=',$request->start_date);
        } elseif ($request->end_date) {
            $query->where('appointment_date', '<=', $request->end_date);
        }
        return $query;
    }

    public function sendReminder(Request $request)
    {
        $appointment = PatientAppointment::find($request->id);

        if (!$appointment || $appointment->email_sent) {
            return response()->json(['success' => false]);
        }

        // Email templates
        $doctorEmail = $appointment->doctor->email;
        $patientEmail = $appointment->user->email;

        $subjectForDoctor = "Appointment Reminder";
        $messageForDoctor = "Hi, Dr. " . $appointment->doctor->name . "! You have an upcoming appointment with " . $appointment->user->name . " on " . $appointment->appointment_date . " at " . $appointment->start_time;



        if (strpos($patientEmail, 'noemail') === 0) {
            // Display message informing the user via phone
            echo "The user has no email, inform them via phone number: " . $appointment->user->phone;
        } else {
            $subjectForPatient = "Appointment Reminder";
            $messageForPatient = "Hi, " . $appointment->user->name . "! This is a reminder for your appointment with Dr. " . $appointment->doctor->name . " on " . $appointment->appointment_date . " at " . $appointment->start_time;

            };
        
        if ($_SERVER['SERVER_NAME'] !== 'localhost') {
            // Send email to doctor
            mail($doctorEmail, $subjectForDoctor, $messageForDoctor);
            // Send email to patient
            mail($patientEmail, $subjectForPatient, $messageForPatient);
        }

        // Mark email as sent in the database
        $appointment->email_sent = 1;
        $appointment->save();

        return response()->json(['success' => true]);
    }


    public function createFromPatientDetails($userid)
    {
        $doctors = User::role('Doctor')->where('status', '1')->get(['id', 'name']);
        $patients = User::role('Patient')->where('status', '1')->with('patientDetails')->get(['id', 'name']);
        $selectedPatientId = $userid;

        return view('patient-appointment.create', compact('doctors', 'patients', 'selectedPatientId'));
    }

    public function create()
    {
        $doctors = User::role('Doctor')->where('status', '1')->orderBy('id', 'desc')->get(['id', 'name']);
        $patients = User::role('Patient')->where('status', '1')->with('patientDetails')->orderBy('id', 'desc')->get(['id', 'name']);

        return view('patient-appointment.create', compact('doctors', 'patients'));
    }


    public function changeStatus(Request $request)
    {
        $statusId = $request->input('statusId');
        $appointmentId = $request->input('appointmentId');
        $appointment = PatientAppointment::find($appointmentId);
        $appointment->appointment_status_id = $statusId;
        $appointment->updated_by = auth()->id();
        $appointment->save();


        if ($_SERVER['SERVER_NAME'] !== 'localhost' && $appointment->appointment_status_id == 8) {
            $messageBodyForPatient = "Hi, " . $appointment->user->name ?? '-' . "! Your Appointment with Doctor: " . $appointment->doctor->name ?? '-'. " has been Cancelled ";
            $subjectForPatient = "Appointment: " . $appointment->appointment_number." Cancelled";
            $messageBodyForAdmin = "Appointment cancelled for Patient Named " . $appointment->user->name ?? '-' . " with Doctor " . $appointment->doctor->name ?? '-';
            $subjectForAdmin = "Appointment Cancelled";
            $messageBodyForDoctor = "Hi, " . $appointment->doctor->name ?? '-' . "! Your Appointment has been cancelled for Patient " . $appointment->user->name ?? '-';
            $subjectForDoctor = "Appointment has been cancelled from System";
            mail( $appointment->user->email,$subjectForPatient,$messageBodyForPatient);
            mail("umerfayyaz633@gmail.com",$subjectForAdmin,$messageBodyForAdmin);
            mail( $appointment->doctor->email,$subjectForDoctor,$messageBodyForDoctor);
        }
        return response()->json(['message' => 'Appointment status updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PatientAppointment  $patientAppointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(PatientAppointment $patientAppointment)
    {
        if ($patientAppointment->exam()->exists())
        return redirect()->route('patient-appointments.index')->with('error', trans('Patient Appointment Cannot be deleted Because Exam Investigation has been created'));

        $patientAppointment->delete();
        return redirect()->route('patient-appointments.index')->with('success', trans('Patient Appointment Deleted Successfully'));
    }



    /**
     * Makes time slots
     *
     * @param  Request $request
     * @param  DoctorSchedule $doctorSchedule
     * @return string
     */


    public function ajaxExample(Request $request)
    {
        // Retrieve data from the request
        $data = $request->input('data'); // Assuming 'data' is the variable we are sending

        // Process the data if needed (in this example, we'll just return the same data)
        return response()->json(['data' => $data]);
    }
    public function bookAppointment(Request $request)
    {
        if ($request->lang) {
            app()->setLocale($request->lang);
        }

        $request->validate([
            'company_id' => ['required', 'integer'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:14']
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user) {
            $request->request->add(['user_id' => $user->id]);
            $this->store($request);
        } else {
            $user = $this->registerNewPatient($request);
            $request->request->add(['user_id' => $user->id]);
            $this->store($request);
        }

        return response()->json(['message' => __('Appointment booked successfully!')], 200);
    }

    /**
     * Registers new patient
     *
     * @param Request $request
     * @return App\Models\User
     */
    private function registerNewPatient(Request $request)
    {
        $password = uniqid();
        $data = $request->only(['company_id', 'name', 'email', 'phone']);
        $data['status'] = '1';
        $data['password'] = bcrypt($password);
        $user = User::create($data);
        $role = Role::where('name', 'Patient')->first();
        $user->assignRole([$role->id]);
        $user->companies()->attach($user->company_id);

        Mail::to($user->email)
            ->queue(new NewUserCredential($user, $password));

        return $user;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PatientAppointment  $patientAppointment
     * @return \Illuminate\Http\Response
     */
    public function show(PatientAppointment $patientAppointment)
    {
        $statuses = AppointmentStatus::get();

        if ((auth()->user()->hasRole('Patient') && auth()->id() != $patientAppointment->user_id) || (auth()->user()->hasRole('Doctor') && auth()->id() != $patientAppointment->doctor_id)) {
            return redirect()->route('dashboard');
        }

        $doctorDetail = DoctorDetail::all();
        $profile = Storage::files("uploads/patient/{$patientAppointment->user->id}/profile_picture");
        $profilePicture = count($profile) > 0 ? $profile[0] : null;

        // Log code
        $logs = UserLogs::where('table_name', 'patient_appointments')->orderBy('id', 'desc')
            ->with('user')
            ->paginate(10);

        return view('patient-appointment.show', compact('patientAppointment', 'statuses', 'profilePicture', 'doctorDetail', 'logs'));
    }


    public function edit(PatientAppointment $patientAppointment)
    {
        // Implementation needed
    }

    public function update(Request $request, PatientAppointment $patientAppointment)
    {
        // Implementation needed
    }
    /**
     * Get doctorwise appointment slots
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getScheduleDoctorWise(Request $request)
    {
        if ($request->lang) {
            app()->setLocale($request->lang);
        }

        $request->validate([
            'userId' => ['required', 'integer', 'exists:users,id'],
            'appointmentDate' => ['required', 'date']
        ]);

        $doctor = User::role('Doctor')->where('id', $request->userId)->where('status', '1')->first();
        $isAvailable = $doctor ? $doctor->doctorSchedules()->where('weekday', date('l', strtotime($request->appointmentDate)))->where('status', '1')->exists() : false;

        // Return status 1 for available, 0 for not available
        $status = $isAvailable ? 1 : 0;

        return response()->json(['status' => $status, 'message' => $isAvailable ? __('Doctor is available on the selected date.') : __('Doctor is not available on the selected date.')], 200);
    }


    public function store(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'doctor_id' => ['required', 'integer', 'exists:users,id'],
            'appointment_date' => ['required', 'date', 'after_or_equal:today'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
            'problem' => ['nullable', 'string', 'max:1000']
        ]);


        $data = $request->only(['user_id', 'doctor_id', 'appointment_date', 'start_time', 'end_time', 'problem']);
        $data['company_id'] = session('company_id');
        $data['created_by'] = auth()->id();


        $existingAppointments = PatientAppointment::where('doctor_id', $data['doctor_id'])
        ->whereDate('appointment_date', $data['appointment_date'])
        ->where(function ($query) use ($data) {
            $query->where(function ($query) use ($data) {
                $query->whereTime('start_time', '<', $data['end_time'])
                      ->whereTime('end_time', '>', $data['start_time']);
            });
        })
        ->exists();

        if ($existingAppointments) {
            return redirect()->back()->with('error', trans('The selected time slot is already booked. Please choose another time.'));
        }



        $appointment = PatientAppointment::create($data);

        $appointment['appointment_number'] = getDocNumber($appointment->id, 'APT');
        $appointment['created_by'] = auth()->id();
        if ($appointment->save()) {
            $url = 'patient-appointments.show';
            $msg = "New Appointment has been Created For You";
            $msgforadmin = "New Appointment has been Created for " . $appointment->doctor->name;
            sendNotification($appointment->id, $url, $msg, $appointment->doctor->id);
            sendNotification($appointment->id, $url, $msgforadmin);

            if ($_SERVER['SERVER_NAME'] !== 'localhost') {
                $messageBodyForPatient = "Hi, " . $appointment->user->name . "! Your Appointment with Doctor: " . $appointment->doctor->name . " has been scheduled at: " . $appointment->appointment_date . ", Please Be in the Clinic a Few Minutes Prior to the Actual Time";
                $subjectForPatient = "Appointment Booking Successful - With Appointment Number As: " . $appointment->appointment_number;
                $messageBodyForAdmin = "A new Appointment created for Patient Named " . $appointment->user->name . " with Doctor " . $appointment->doctor->name . " has been created";
                $subjectForAdmin = "A New Appointment Added to System";
                $messageBodyForDoctor = "Hi, " . $appointment->doctor->name . "! Your New Appointment is Scheduled with Patient " . $appointment->user->name . " At: " . $appointment->appointment_date;
                $subjectForDoctor = "A New Appointment for You Added to System";
                mail( $appointment->user->email,$subjectForPatient,$messageBodyForPatient);
                mail("umerfayyaz633@gmail.com",$subjectForAdmin,$messageBodyForAdmin);
                mail( $appointment->doctor->email,$subjectForDoctor,$messageBodyForDoctor);

            }

            // Create an event for the calendar
            $eventData = [
                'title' => 'Appointment with ' . $appointment->doctor->name,
                'doctor_id' => $appointment->doctor->id,
                'patient_id' => $appointment->user->id,
                'description' => $appointment->problem,
                'start_date' => $appointment->appointment_date,
                'end_date' => $appointment->appointment_date,
                'start_time' => $appointment->start_time,
                'end_time' => $appointment->end_time,
                'eventtype' => 'appointment'
            ];
            Event::updateOrCreate(['id' => $appointment->id], $eventData);
        }

        return redirect()->route('patient-appointments.index', $appointment->id)->with('success', trans('Patient Appointment Created Successfully'));
    }
}
