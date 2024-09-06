<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DdDrugHistory;
use Illuminate\Support\Facades\Auth;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;

class DdDrugHistoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->export) {
            return $this->doExport($request);
        }
        $drugHistories = $this->filter($request)->orderBy('id', 'desc')->paginate(10);
        return view('dd-drug-history.index', compact('drugHistories'));
    }
    private function doExport(Request $request)
    {
        // Retrieve all data without filters
        $ddDrugHistory = DdDrugHistory::get();

        // Prepare data for export
        $data = $ddDrugHistory->map(function ($drugHistories) {
            return [
                $drugHistories->id,
                $drugHistories->title,
                $drugHistories->description ?? 'N/A',
                $drugHistories->status == '1' ? 'Active' : 'Inactive',
                $drugHistories->created_at,
                $drugHistories->updated_at,
            ];
        })->toArray();

        // Define headers for the export
        $headers = ['ID', 'Title', 'Description', 'Status', 'Created At', 'Updated At'];

        return Excel::download(new GenericExport($data, $headers), 'dddrugHistories.xlsx');
    }



    private function filter(Request $request)
    {
        $query = DdDrugHistory::query();

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

        return view('dd-drug-history.create');
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
        $drugHistoryData = $request->only(['title', 'description']);
        $drugHistoryData['created_by'] = Auth::id(); // Add the authenticated user's ID

        // Store the validated data into the database
        $drugHistory = new DdDrugHistory($drugHistoryData);
        $drugHistory->save();
        $DdDrugHistory= $drugHistory->id;
        // Redirect to the medical history index route with a success message
        return   redirect()->route('dd-drug-history.edit',$DdDrugHistory)->with('success', trans('Drug history created successfully'));
    }
    public function show(DdDrugHistory $DdDrugHistory)
    {
        return view('dd-drug-history.show', compact('DdDrugHistory'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorDetail  $doctorDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(DdDrugHistory $DdDrugHistory)
    {

        return view('dd-drug-history.edit', compact('DdDrugHistory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoctorDetail  $doctorDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,DdDrugHistory $DdDrugHistory)

    {
        $this->validation($request);
        $data = $request->all();
        $data['updated_by'] = auth()->id();
        $DdDrugHistory->update($data);
        return   redirect()->route('dd-drug-history.edit', $DdDrugHistory)->with('success', trans('Drug history updated successfully'));

    }



    public function destroy(DdDrugHistory $DdDrugHistory)
    {
        $DdDrugHistory->delete();
        return redirect()->route('dd-drug-history.index')->with('success', trans('Drug history Deleted Successfully'));
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
