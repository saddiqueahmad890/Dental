<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DdMedicalHistory;
use Illuminate\Support\Facades\Auth;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;

class DdMedicalHistoryController extends Controller
{
      /**
     * Constructor
     */
    // function __construct()
    // {
    //     $this->middleware('permission:doctor-detail-read|doctor-detail-create|doctor-detail-update|doctor-detail-delete', ['only' => ['index', 'show']]);
    //     $this->middleware('permission:doctor-detail-create', ['only' => ['create', 'store']]);
    //     $this->middleware('permission:doctor-detail-update', ['only' => ['edit', 'update']]);
    //     $this->middleware('permission:doctor-detail-delete', ['only' => ['destroy']]);
    // }

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

        $medicalhistories  = $this->filter($request)->orderBy('id', 'desc')->paginate(10);


        return view('dd-medical-history.index', compact('medicalhistories'));
    }
    private function doExport(Request $request)
    {
        // Retrieve all data without filters
        $ddMedicalHistory = DdMedicalHistory::get();

        // Prepare data for export
        $data = $ddMedicalHistory->map(function ($medicine) {
            return [
                $medicine->id,
                $medicine->title,
                $medicine->description,
                $medicine->status == '1' ? 'Active' : 'Inactive',
                $medicine->created_at,
                $medicine->updated_at,
            ];
        })->toArray();

        // Define headers for the export
        $headers = ['ID', 'Title', 'Description', 'Status', 'Created At', 'Updated At'];

        return Excel::download(new GenericExport($data, $headers), 'DdMedicalHistory.xlsx');
    }


    private function filter(Request $request)
    {
        $query = DdMedicalHistory::query();

        if ($request->has('title') && $request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
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

        return view('dd-medical-history.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $this->validation($request);

        // Extract and add 'created_by' to the data array
        $medicalHistoryData = $request->only(['title', 'description']);
        $medicalHistoryData['created_by'] = Auth::id(); // Add the authenticated user's ID

        // Store the validated data into the database
        $medicalHistory = new DdMedicalHistory($medicalHistoryData);
        $medicalHistory->save();
        $DdMedicalHistory=$medicalHistory->id;
        // Redirect to the edit route with a success message
        return redirect()->route('dd-medical-history.edit',  $DdMedicalHistory)
            ->with('success', trans('Medical history created successfully'));
    }

    public function show(DdMedicalHistory $DdMedicalHistory)
    {
        return view('dd-medical-history.show', compact('DdMedicalHistory'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorDetail  $doctorDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(DdMedicalHistory $DdMedicalHistory)
    {

        return view('dd-medical-history.edit', compact('DdMedicalHistory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoctorDetail  $doctorDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,DdMedicalHistory $DdMedicalHistory)

    {
        $this->validation($request);
        $data = $request->all();
        $data['updated_by'] = Auth::id();

        $DdMedicalHistory->update($data);
        return redirect()->route('dd-medical-history.edit',  $DdMedicalHistory)
            ->with('success', trans('Medical history updated successfully'));
    }



    public function destroy(DdMedicalHistory $DdMedicalHistory)
    {
        $DdMedicalHistory->delete();
        return redirect()->route('dd-medical-history.index')->with('success', trans('Medical history Deleted Successfully'));
    }
    public function store1(Request $request)
    {
      echo "hello";
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
            'title' => ['required', 'unique:users,name,' . $id, 'max:255'],
            // Adjust max length as needed

        ]);
    }
}
