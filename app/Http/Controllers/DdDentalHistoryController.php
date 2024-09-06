<?php

namespace App\Http\Controllers;

use App\Models\UserLogs;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use App\Models\DdDentalHistory;
use Illuminate\Support\Facades\Auth;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;

class DdDentalHistoryController extends Controller
{
    use Loggable;
    public function index(Request $request)
    {
        if ($request->export) {
            return $this->doExport($request);
        }

        $dentalHistories = $this->filter($request)->orderBy('id', 'desc')->paginate(10);
        return view('dd-dental-history.index', compact('dentalHistories'));
    }
    private function doExport(Request $request)
    {
        // Retrieve all data without filters
        $ddDentals = DdDentalHistory::get();

        // Prepare data for export
        $data = $ddDentals->map(function ($dental) {
            return [
                $dental->id,
                $dental->title,
                $dental->description ?? 'N/A',
                $dental->status == '1' ? 'Active' : 'Inactive',
                $dental->created_at,
                $dental->updated_at,
            ];
        })->toArray();

        // Define headers for the export
        $headers = ['ID', 'Title', 'Description', 'Status', 'Created At', 'Updated At'];

        return Excel::download(new GenericExport($data, $headers), 'DddentalHistories.xlsx');
    }







    private function filter(Request $request)
    {
        $query = DdDentalHistory::query();

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

        return view('dd-dental-history.create');
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
        $dentalHistoryData = $request->only(['title', 'description']);
        $dentalHistoryData['created_by'] = Auth::id(); // Add the authenticated user's ID

        // Store the validated data into the database
        $dentalHistory = new DdDentalHistory($dentalHistoryData);
        $dentalHistory->save();
        $DdDentalHistory = $dentalHistory->id;
        // Redirect to the medical history index route with a success message
        return   redirect()->route('dd-dental-history.edit', $DdDentalHistory)->with('success', trans('Dental history created successfully'));
    }
    public function show(DdDentalHistory $DdDentalHistory)
    {
        return view('dd-dental-history.show', compact('DdDentalHistory'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorDetail  $doctorDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(DdDentalHistory $DdDentalHistory)
    {
        // start of log
        $logs = UserLogs::where('table_name', 'dd_dental_histories')->orderBy('id', 'desc')
        ->with('user')
        ->paginate(10);
        // end of log
        return view('dd-dental-history.edit', compact('DdDentalHistory','logs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoctorDetail  $doctorDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DdDentalHistory $DdDentalHistory)

    {
        $this->validation($request);
        $data = $request->all();
        $data['updated_by'] = Auth::id();
        $DdDentalHistory->update($data);
         return   redirect()->route('dd-dental-history.edit', $DdDentalHistory)->with('success', trans('Dental history updated successfully'));
    }



    public function destroy(DdDentalHistory $DdDentalHistory)
    {
        $DdDentalHistory->delete();
        return redirect()->route('dd-dental-history.index')->with('success', trans('Dental history Deleted Successfully'));
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

        ]);
    }
}
