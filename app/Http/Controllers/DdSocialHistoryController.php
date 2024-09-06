<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DdSocialHistory;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogs;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;


class DdSocialHistoryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->export) {
            return $this->doExport($request);
        }

        $socialHistories = $this->filter($request)->orderBy('id', 'desc')->paginate(10);
        return view('dd-social-history.index', compact('socialHistories'));
    }
    private function doExport(Request $request)
    {
        // Retrieve all data without filters
        $ddSocialHistory = DdSocialHistory::get();

        // Prepare data for export
        $data = $ddSocialHistory->map(function ($social) {
            return [
                $social->id,
                $social->title,
                $social->description,
                $social->status == '1' ? 'Active' : 'Inactive',
                $social->created_at,
                $social->updated_at,
            ];
        })->toArray();

        // Define headers for the export
        $headers = ['ID', 'Title', 'Description', 'Status', 'Created At', 'Updated At'];

        return Excel::download(new GenericExport($data, $headers), 'DdSocialHistory.xlsx');
    }


    private function filter(Request $request)
    {
        $query = DdSocialHistory::query();

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

        return view('dd-social-history.create');
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
        $socialhistoryData = $request->only(['title', 'description']);
        $socialhistoryData['created_by'] = Auth::id(); // Add the authenticated user's ID

        // Store the validated data into the database
        $socialHistory = new DdSocialHistory($socialhistoryData);
        $socialHistory->save();
        $DdSocialHistory = $socialHistory->id;
        // Redirect to the medical history index route with a success message
        return   redirect()->route('dd-social-history.edit', $DdSocialHistory)->with('success', trans('social history created successfully'));
    }
    public function show(DdSocialHistory $DdSocialHistory)
    {
        return view('dd-social-history.show', compact('DdSocialHistory'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DoctorDetail  $doctorDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(DdSocialHistory $DdSocialHistory)
    {
        return view('dd-social-history.edit', compact('DdSocialHistory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DoctorDetail  $doctorDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DdSocialHistory $DdSocialHistory)

    {
        $this->validation($request);
        $DdSocialHistory->update($request->all());
        return   redirect()->route('dd-social-history.edit', $DdSocialHistory)->with('success', trans('social history updated successfully'));

    }



    public function destroy(DdSocialHistory $DdSocialHistory)
    {
        $DdSocialHistory->delete();
        return redirect()->route('dd-social-history.index')->with('success', trans('Social history Deleted Successfully'));
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
