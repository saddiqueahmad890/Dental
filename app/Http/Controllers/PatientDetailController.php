<?php

namespace App\Http\Controllers;

use App\Traits\Loggable;
use App\Models\UserLogs;
use App\Exports\UserExport;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\DdBloodGroup;
use App\Models\Insurance;
use App\Models\MaritalStatus;
use App\Models\PatientDetail;
use App\Models\Invoice;
use App\Models\File;
use App\Models\EnquirySource;
use App\Models\ExamInvestigation;
use App\Models\InsuranceProvider;
use App\Models\PatientAppointment;
use App\Models\PatientDentalHistory;
use App\Models\PatientDrugHistory;
use App\Models\PatientMedicalHistory;
use App\Models\PatientSocialHistory;
use App\Models\PatientTreatmentPlan;
use App\Models\Prescription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;



class PatientDetailController extends Controller
{
    use Loggable;
    /**
     * Constructor
     */
    function __construct()
    {
        $this->middleware('permission:patient-detail-read|patient-detail-create|patient-detail-update|patient-detail-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:patient-detail-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:patient-detail-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:patient-detail-delete', ['only' => ['destroy']]);
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


        // Retrieve paginated patient details
        $patientDetails = $this->filter($request)->orderBy('created_at', 'desc')->paginate(10);

        // Retrieve profile pictures for each patient detail
        foreach ($patientDetails as $patientDetail) {
            $profile = Storage::files("uploads/patient/{$patientDetail->id}/profile_picture");
            $patientDetail->profilePicture = count($profile) > 0 ? $profile[0] : null;
        }

        // Pass the data to the view
        return view('patient-detail.index', compact('patientDetails',));
    }

    /**
     * Performs exporting
     *
     * @param Request $request
     * @return void
     */
    private function doExport(Request $request)
    {
        return Excel::download(new UserExport($request, 'Patient'), 'Patients.xlsx');
    }

    /**
     * Filter function
     *
     * @param Request $request
     * @return Illuminate\Database\Eloquent\Builder
     */
    private function filter(Request $request)
    {
        if (auth()->user()->hasRole('Patient')) {
            $query = User::role('Patient')
            ->where('company_id', session('company_id'))
            ->where('id', auth()->id())
                ->with('patientDetails')
                ->latest();
        } else {
            $query = User::role('Patient')->where('company_id', session('company_id'))->latest();
        }

        if ($request->name) {
            $query->where('name', 'like', $request->name . '%');
        }
        if ($request->mrn_number) {
            $query->whereHas('patientDetails', function ($q) use ($request) {
                $q->where('mrn_number', 'like', $request->mrn_number . '%');
            });
        }

        if ($request->start_date && $request->end_date) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($request->start_date) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $query->where('created_at', '>=', $startDate);
        }elseif ($request->end_date) {
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->where('created_at', '<=', $endDate);
        }
        return $query;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bloodGroups = DdBloodGroup::all();
        $maritalStatuses = MaritalStatus::all();
        $enquirysource = EnquirySource::all();
        $insuranceProviders = InsuranceProvider::all();
        return view('patient-detail.create', compact('bloodGroups', 'enquirysource', 'maritalStatuses','insuranceProviders'));
    }



    public function store(Request $request)
    {
        $this->validation($request);

        $userData = $request->only(['name', 'email', 'phone', 'address', 'gender', 'blood_group', 'enquiry']);
        $patientData = $request->only(['other_details', 'marital_status', 'insurance_provider_id', 'cnic', 'credit_balance', 'area', 'enquirysource', 'city',]);
        $patientData['created_by']= auth()->id();
        $userData['company_id'] = session('company_id');
        $userData['password'] = bcrypt($request->password);

        if ($request->date_of_birth) {
            $userData['date_of_birth'] = Carbon::parse($request->date_of_birth);
        }

        DB::transaction(function () use ($userData, $patientData, $request, &$user) {
            $user = User::create($userData);
            $role = Role::where('name', 'Patient')->first();
            $user->assignRole([$role->id]);
            $user->companies()->attach(session('company_id'));

            $patientDetails = new PatientDetail($patientData);
            $patientDetails->user_id = $user->id;
            $patientDetails['mrn_number'] = getDocNumber($user->id, '');


            if ($patientDetails->save()) {
                $url= 'patient-details.show';
                $msg= "New patient has been registered" ;
                sendNotification($user->id,$url,$msg);
                if ($_SERVER['SERVER_NAME'] !== 'localhost') {
                    $messageBodyForAdmin = "A new patient ".$userData['name']." and MRN# ".$patientDetails['mrn_number']." has been registered";
                    $subjectForAdmin = "A new patient has been registered MRN#".$patientDetails['mrn_number'];
                    $messageBodyForPatient = "Hi  ".$userData['name'].", Your registration process has be completed successfully, Please note down your MRN# ".$patientDetails['mrn_number'];
                    $subjectForPatient = "Registration successfull - Welcome to our clinic";
                    mail($userData['email'],$subjectForPatient,$messageBodyForPatient);
                    mail("umerfayyaz633@gmail.com",$subjectForAdmin,$messageBodyForAdmin);
                }
            }
        });



        // Redirect to the edit page of the newly created patient
        return redirect()->route('patient-details.edit', $user->id)->with('success', trans('Patient Added Successfully'));
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $patientDetail
     * @return \Illuminate\Http\Response
     */
    public function show(User $patientDetail)
    {
        if (auth()->user()->hasRole('Patient') && auth()->id() != $patientDetail->id) {
            return redirect()->route('dashboard');
        }

        $profile = Storage::files("uploads/patient/{$patientDetail->id}/profile_picture");
        $profilePicture = count($profile) > 0 ? $profile[0] : null;
        $insuranceFiles=File::where('record_id',$patientDetail->id)->where('table_name','patient')->where('record_type','insurance_card')->count();
        $patientDrugHistories = PatientDrugHistory::where('patient_id', $patientDetail->id)->get();
        $patientMedicalHistories = PatientMedicalHistory::where('patient_id', $patientDetail->id)->get();
        $patientSocialHistories = PatientSocialHistory::where('patient_id', $patientDetail->id)->get();
        $patientDentalHistories = PatientDentalHistory::where('patient_id', $patientDetail->id)->get();
        $patientAppointments = PatientAppointment::where('user_id', $patientDetail->id)->orderBy('created_at', 'desc')->get();
        $examInvestigations = ExamInvestigation::where('patient_id', $patientDetail->id)->orderBy('created_at', 'desc')->get();
        $patientTreatmentPlans = PatientTreatmentPlan::where('patient_id', $patientDetail->id)->orderBy('created_at', 'desc')->get();
        $prescriptions = Prescription::where('user_id', $patientDetail->id)->orderBy('created_at', 'desc')->get();
        $invoices = Invoice::where('user_id', $patientDetail->id)->orderBy('created_at', 'desc')->get();

        return view('patient-detail.show', compact('patientDetail','insuranceFiles' ,'profilePicture', 'patientDrugHistories', 'patientMedicalHistories', 'patientSocialHistories', 'patientDentalHistories','patientAppointments','examInvestigations','patientTreatmentPlans','prescriptions','invoices'));
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $patientDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(User $patientDetail)
    {
        $id = $patientDetail->id;
        $bloodGroups = DdBloodGroup::all();
        $enquirysource = EnquirySource::all();
        $maritalStatuses = MaritalStatus::all();
        $insuranceProviders = InsuranceProvider::orderBy('created_at','desc')->get();
        $insuranceFiles=File::where('record_id',$patientDetail->id)->where('table_name','patient')->where('record_type','insurance_card')->count();
        // dd($insuranceFiles);
        //    start log code
        $logs = UserLogs::whereIn('table_name', ['users', 'patient_details'])
            ->orderBy('id', 'desc')
            ->with('user')
            ->paginate(10);

        return view('patient-detail.edit', compact('patientDetail', 'enquirysource','bloodGroups', 'maritalStatuses','logs','insuranceProviders','insuranceFiles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $patientDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $patientDetail)
    {
        $this->validation($request, $patientDetail->id);
        $userData = $request->only(['name', 'email', 'phone', 'address', 'gender', 'blood_group','status']);
        $patientData = $request->only(['other_details', 'marital_status', 'insurance_provider_id', 'cnic', 'area', 'credit_balance', 'enquirysource', 'city',]);
        $patientData['updated_by']= auth()->id();

        if ($request->password)
            $userData['password'] = bcrypt($request->password);

        if ($request->date_of_birth)
            $userData['date_of_birth'] = Carbon::parse($request->date_of_birth);

        DB::transaction(function () use ($patientDetail, $userData) {
            $patientDetail->update($userData);
        });


        if($patientDetail->patientDetails == null){
            $patient = new PatientDetail($patientData);
            $patient->user_id = $patientDetail->id;
            $patient['mrn_number'] = getDocNumber($patientDetail->id, '');
            $patient->save();

        }
        else{
        $patient = PatientDetail::where('user_id', $patientDetail->id)->firstOrFail();
        DB::transaction(function () use ($patient, $patientData) {
            $patient->update($patientData);
        });
    }




        return redirect()->route('patient-details.edit', $patientDetail->id)->with('success', trans('Patient Updated Successfully'));
    }

    public function updateInsuranceVerified(Request $request, $id)
    {
        $patient = PatientDetail::where('user_id',$id)->first();
        $patient->insurance_verified = $request->input('insurance_verified');
        $patient->insurance_verified_by = auth()->id();
        $patient->insurance_verified_at= Carbon::now();

        if ($patient->save()) {
            return response()->json(['success' => true,'actual val saved:'=>$patient->insurance_verified]);
        } else {
            return response()->json(['success' => false]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $patientDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $patientDetail)
    {
        // Check if the patient has any related histories
        $hasHistories = $patientDetail->patientDentalHistories()->exists() ||
            $patientDetail->patientDrugHistories()->exists() ||
            $patientDetail->patientSocialHistories()->exists() ||
            $patientDetail->patientMedicalHistories()->exists();

        if ($hasHistories) {
            return redirect()->route('patient-details.index')->with('error', trans('Patient cannot be deleted'));
        }

        // Delete patient details
        $patientDetail->patientDetails->delete();
        $patientDetail->delete();

        return redirect()->route('patient-details.index')->with('success', trans('Patient Deleted Successfully'));
    }


    /**
     * validation check for create & edit
     *
     * @param Request $request
     * @param integer $id
     * @return void
     */

    private function validation(Request $request, $id = 0)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email,' . $id, 'max:255'],
            'phone' => ['nullable', 'string', 'max:14'],
            'gender' => ['nullable', 'in:male,female'],
            'cnic' => ['nullable', 'string','max:15'],
            'blood_group' => ['nullable', 'numeric'],
            'marital_status' => ['nullable', 'numeric'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'address' => ['nullable', 'string', 'max:1000'],
            'date_of_birth' => ['nullable', 'date'],
            'cnic_file.*' => 'file|mimes:png,jpg,jpeg,pdf,xml,txt|max:2048',
            'insurance_card.*' => 'file|mimes:png,jpg,jpeg,pdf,xml,txt|max:2048',
            'other_files.*' => 'file|mimes:png,jpg,jpeg,pdf,xml,txt|max:2048',



        ]);

        if (empty($id)) {
            $request->validate([
                'password' => ['required', 'string', 'min:8', 'max:255']
            ]);
        } else {
            $request->validate([
                'password' => ['nullable', 'string', 'min:8', 'max:255']
            ]);
        }
    }
    public function history(User $patientDetail)
    {
        // Retrieve profile picture
        $profile = Storage::files("uploads/patient/{$patientDetail->id}/profile_picture");
        $profilePicture = count($profile) > 0 ? $profile[0] : null;

        // Fetch patient histories
        $patientDrugHistories = PatientDrugHistory::where('patient_id', $patientDetail->id)->get();
        $patientMedicalHistories = PatientMedicalHistory::where('patient_id', $patientDetail->id)->get();
        $patientSocialHistories = PatientSocialHistory::where('patient_id', $patientDetail->id)->get();
        $patientDentalHistories = PatientDentalHistory::where('patient_id', $patientDetail->id)->get();

        // Flags for whether histories exist
        $hasDrugHistory = $patientDrugHistories->isNotEmpty();
        $hasMedicalHistory = $patientMedicalHistories->isNotEmpty();
        $hasSocialHistory = $patientSocialHistories->isNotEmpty();
        $hasDentalHistory = $patientDentalHistories->isNotEmpty();

        // Return the view with the fetched data and flags
        return view('patient-detail.history', compact(
            'patientDetail',
            'profilePicture',
            'patientDrugHistories',
            'patientMedicalHistories',
            'patientSocialHistories',
            'patientDentalHistories',
            'hasDrugHistory',
            'hasMedicalHistory',
            'hasSocialHistory',
            'hasDentalHistory'
        ));
    }

}
