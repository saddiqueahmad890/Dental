<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ConsultanceyFee;
use App\Models\PatientDetail;
use App\Models\User;
// use App\Models\Carbon;
use App\Models\Company;
use Illuminate\Http\Request;

class ConsultanceyFeeController extends Controller
{
    public function __construct()
{
    $this->middleware('permission:consultancey-read|consultancy-create|consultancy-update|consultancy-delete', ['only' => ['index', 'show']]);
    $this->middleware('permission:consultancey-create', ['only' => ['create', 'store']]);
    $this->middleware('permission:consultancey-update', ['only' => ['edit', 'update']]);
    $this->middleware('permission:consultancey-delete', ['only' => ['destroy']]);
}



    public function index()
    {

        $consultancies = ConsultanceyFee::orderby('id','desc')->paginate(10);
        return view('consultancey-fee.index', compact('consultancies' ));
    }

    public function create(Request $request)
    {
        // Check if ConsultanceyFee exists for the given user_id
        $consultanceyFee = ConsultanceyFee::where('user_id', $request->userid)->first();

        if ($consultanceyFee) {
            // If ConsultanceyFee exists, show the 'show' view
            $patientDetail = User::find($request->userid);
            $company = Company::find(1);
            $company->setSettings();
            return view('consultancey-fee.show', compact('consultanceyFee', 'company', 'patientDetail'));
        } else {
            // If ConsultanceyFee doesn't exist, show the 'create' view
            $patients = User::whereHas('roles', function ($query) {
                $query->whereIn('name', ['Patient']);
            })->get();
            $patientDetail = User::find($request->userid);
            return view('consultancey-fee.create', compact('patientDetail', 'patients'));
        }
    }

    public function store(Request $request)
    {

        $this->validation($request);

        $data = $request->only(['user_id','date','amount','description']);
        ConsultanceyFee::create($data);
        return redirect()->route('consultancey-fees.index')->with('success', 'Consultancey fee created successfully.');
    }



    public function show(ConsultanceyFee $consultanceyFee)
    {
        $patientDetail = User::find($consultanceyFee->user_id);

        $company = Company::find(1);
        $company->setSettings();
        return view('consultancey-fee.show', compact('consultanceyFee', 'company','patientDetail'));
    }


    public function edit(ConsultanceyFee $consultanceyFee)
    {
        return view('consultancey-fee.edit', compact('consultanceyFee'));
    }

    public function update(Request $request, ConsultanceyFee $consultanceyFee)
    {

        $this->validation($request);
        $data = $request->only(['user_id', 'amount', 'description']);
        $consultanceyFee->update($data);
        return redirect()->route('consultancey-fees.index')->with('success', trans('consultancey Updated Successfully'));
    }


    public function destroy(ConsultanceyFee $consultanceyFee)
    {
        $consultanceyFee->delete();
        return redirect()->route('consultancey-fees.index')->with('success', trans('ConsultanceyFee Removed Successfully'));
    }


    private function validation(Request $request, $id = 0)
    {
        // ;
        $request->validate([
            // 'date'=>['required','date'],
            'user_id' => ['required', 'numeric'],
            'amount' => ['required', 'numeric'],
            'description' => ['nullable', 'string','max:255']
            ]);
    }
}
