<?php

namespace App\Http\Controllers;

use App\Models\UserLogs;
use App\Exports\UserExport;
use App\Models\User;
use App\Traits\Loggable;
use App\Models\DoctorDetail;
use App\Models\Invoice;
use App\Models\Prescription;
use App\Models\PatientAppointment;
use App\Models\ExamInvestigation;
use App\Models\PatientTreatmentPlan;
use App\Models\DdBloodGroup;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;
class DoctorDetailController extends Controller
{
    /**
     * Constructor
     */
    function __construct()
    {
        $this->middleware('permission:doctor-detail-read|doctor-detail-create|doctor-detail-update|doctor-detail-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:doctor-detail-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:doctor-detail-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:doctor-detail-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {


        if ($request->export) {
            return $this->doExport($request);
        }
        $defaultImagePath ='alu/male.png';


        $doctorDetails = $this->filter($request)->with('user')->orderBy('id', 'desc')->paginate(10);
        return view('doctor-detail.index', compact('doctorDetails', 'defaultImagePath'));
    }

    public function doExport(Request $request)
    {
        // Retrieve filtered data
        $doctorDetails = $this->filter($request)
            ->with(['user']) // eager load relationships
            ->get();

        // Prepare data for export
        $data = $doctorDetails->map(function ($doctorDetail) {
            return [
                'ID' => $doctorDetail->id,
                'User Name' => $doctorDetail->user->name ?? 'N/A',
                'Specialist' => $doctorDetail->specialist,
                'Designation' => $doctorDetail->designation,
                'Biography' => $doctorDetail->doctor_biography,
                'Created At' => $doctorDetail->created_at,
                'Updated At' => $doctorDetail->updated_at,
            ];
        })->toArray();

        // Define headers for the export
        $headers = ['ID', 'User Name', 'Department', 'Specialist', 'Designation', 'Biography', 'Created At', 'Updated At'];

        return Excel::download(new GenericExport($data, $headers), 'DoctorDetails.xlsx');
    }




    /**
     * Filter function
     *
     * @param Request $request
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function filter(Request $request)
    {
        $query = DoctorDetail::with('user')
            ->whereHas('user', function ($q) use ($request) {
                $q->where('company_id', session('company_id'));

                if ($request->name) {
                    $q->where('name', 'like', $request->name . '%');
                }

                if ($request->email) {
                    $q->where('email', 'like', $request->email . '%');
                }

                if ($request->phone) {
                    $q->where('phone', 'like', $request->phone . '%');
                }
            });

        if ($request->start_date && $request->end_date) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($request->start_date) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $query->where('created_at', '>=', $startDate);
        } elseif ($request->end_date) {
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->where('created_at', '<=', $endDate);
        }

        return $query;
    }

    /**
     * Get active doctor list
     *
     * @return \Illuminate\Http\Response
     */
    public function getDoctorList(Request $request)
    {
        if ($request->lang)
            app()->setLocale($request->lang);

        $doctors = User::role('Doctor')->where('status', '1')->get();
        $output = '<option value="">' . __('Select Doctor') . '*</option>';
        foreach ($doctors as $doctor) {
            $output .= '<option value="' . $doctor->id . '">' . $doctor->name . '</option>';
        }
        return response()->json($output, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bloodGroups = DdBloodGroup::all();
        return view('doctor-detail.create', compact('bloodGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */




    public function store(Request $request){
        $this->validation($request);

        $userData = $request->only(['name', 'email', 'phone', 'address', 'gender', 'blood_group']);
        $userData['company_id'] = session('company_id');
        $userData['password'] = bcrypt($request->password);

        $logoUrl = "";
        if ($request->hasFile('photo')) {
            $logo = $request->photo;
            $logoNewName = time() . $logo->getClientOriginalName();
            $logo->move('lara/doctor', $logoNewName);
            $logoUrl = 'lara/doctor/' . $logoNewName;
            $userData['photo'] = $logoUrl;
        }

        if ($request->date_of_birth)
            $userData['date_of_birth'] = Carbon::parse($request->date_of_birth);

        $doctorData = $request->only(['specialist', 'designation', 'doctor_biography','commission']);

        DB::transaction(function () use ($userData, $doctorData, &$doctorDetail, &$user) {
            $user = User::create($userData);
            $role = Role::where('name', 'Doctor')->first();
            $user->assignRole([$role->id]);
            $user->companies()->attach(session('company_id'));
            $doctorData['user_id'] = $user->id;
            $doctorData['created_by'] = auth()->id();

            $doctorDetail = DoctorDetail::create($doctorData);
        });

        $url= 'doctor-details.show';
        $msg= "New Doctor Has been registered" ;
        sendNotification($doctorDetail->id,$url,$msg);

        if ($_SERVER['SERVER_NAME'] !== 'localhost') {
            $messageBodyForAdmin = "A new Doctor ".$userData['name']." has been registered";
            $subjectForAdmin = "A new Doctor has been registered";
            $messageBodyForDoctor = "Hi, ".$userData['name']."! Your registration process has be completed successfully";
            $subjectForDoctor = "Registration successfull - Welcome to our clinic";
            mail($userData['email'],$subjectForDoctor,$messageBodyForDoctor);
            mail("umerfayyaz633@gmail.com",$subjectForAdmin,$messageBodyForAdmin);
        }

        return redirect()->route('doctor-details.edit', $doctorDetail->id)
            ->with('success', trans('Doctor Added Successfully'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DoctorDetail  $doctorDetail
     * @return \Illuminate\Http\Response
     */
    public function show(DoctorDetail $doctorDetail)
    {
        $patientAppointments = PatientAppointment::where('doctor_id', $doctorDetail->user->id)->orderBy('created_at', 'desc')->get();
        $examInvestigations = ExamInvestigation::where('doctor_id', $doctorDetail->user->id)->orderBy('created_at', 'desc')->get();
        $patientTreatmentPlans = PatientTreatmentPlan::where('doctor_id', $doctorDetail->user->id)->orderBy('created_at', 'desc')->get();
        $prescriptions = Prescription::where('doctor_id', $doctorDetail->user->id)->orderBy('created_at', 'desc')->get();
        $invoices = Invoice::where('user_id', $doctorDetail->user->id)->orderBy('created_at', 'desc')->get();
        return view('doctor-detail.show', compact('doctorDetail','patientAppointments','examInvestigations','patientTreatmentPlans','prescriptions','invoices'));    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorDetail  $doctorDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(DoctorDetail $doctorDetail)
    {
        $bloodGroups = DdBloodGroup::all();

        // start of log
        $logs = UserLogs::where('table_name', 'doctor_details')->orderBy('id', 'desc')
        ->with('user')
        ->paginate(10);
                // end of log


        return view('doctor-detail.edit', compact('doctorDetail', 'bloodGroups','logs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoctorDetail  $doctorDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DoctorDetail $doctorDetail)
    {
        $this->validation($request, $doctorDetail->user_id);

        $userData = $request->only(['name', 'email', 'phone', 'address', 'gender', 'blood_group', 'status']);

        if ($request->password)
            $userData['password'] = bcrypt($request->password);


        $logoUrl = "";
        if ($request->photo) {
            $logo = $request->photo;
            $logoNewName = time() . $logo->getClientOriginalName();
            $logo->move('lara/doctor', $logoNewName);
            $logoUrl = 'lara/doctor/' . $logoNewName;
            $userData['photo'] = $logoUrl;
        }

        if ($request->date_of_birth)
            $userData['date_of_birth'] = Carbon::parse($request->date_of_birth);

        $doctorData = $request->only(['specialist', 'designation', 'doctor_biography']);

        DB::transaction(function () use ($userData, $doctorData, $doctorDetail) {
            $doctorDetail->user->update($userData);
            $doctorDetail->update($doctorData);
        });

        return redirect()->route('doctor-details.edit', $doctorDetail->id)->with('success', trans('Doctor Updated Successfully'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DoctorDetail  $doctorDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(DoctorDetail $doctorDetail)
    {
        $doctorDetail->user->delete();
        return redirect()->route('doctor-details.index')->with('success', trans('Doctor Deleted Successfully'));
    }

    /**
     * Validation function
     *
     * @param Request $request
     * @return void
     */
    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $id, 'max:255'],
            'phone' => ['nullable', 'string', 'max:14'],
            'specialist' => ['nullable', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'gender' => ['nullable', 'in:male,female'],
            'blood_group' => ['nullable', 'numeric'],
            'commission' => ['required', 'numeric'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'address' => ['nullable', 'string', 'max:1000'],
            'date_of_birth' => ['nullable', 'date'],
            'doctor_biography' => ['nullable', 'string', 'max:1000'],
        ]);

        if (empty($id))
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'max:255']
            ]);
        else
            $request->validate([
                'password' => ['nullable', 'string', 'min:8', 'max:255']
            ]);
    }
}

