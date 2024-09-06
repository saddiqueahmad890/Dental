<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoryOfChiefComplaints;

class HistoryOfChiefComplaintsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $chiefHistories = HistoryOfChiefComplaints::paginate(10)->withQueryString();
        return view('chief-complaint.index',compact('chiefHistories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('chief-complaint.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    $validatedData = $request->validate([
        'complaint_name' => 'required|string|max:255',
        'status' => 'required'
    ]);
    $chiefComplaints = new HistoryOfChiefComplaints();
    $chiefComplaints->complaint_name = $validatedData['complaint_name'];
    $chiefComplaints->status = $validatedData['status'];
    $chiefComplaints->created_by = Auth::id();
    $chiefComplaints->save();
    return redirect()->route('chief-complaints.index')->with('success', 'Complaints Saved successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HistoryOfChiefComplaints  $historyOfChiefComplaints
     * @return \Illuminate\Http\Response
     */
    public function show(HistoryOfChiefComplaints $historyOfChiefComplaints)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HistoryOfChiefComplaints  $historyOfChiefComplaints
     * @return \Illuminate\Http\Response
     */
    public function edit($complaintId)
    {
        $chiefComplaints = HistoryOfChiefComplaints::find($complaintId);
        return view('chief-complaint.edit',compact('chiefComplaints'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HistoryOfChiefComplaints  $historyOfChiefComplaints
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'complaint_name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $chiefComplaints = HistoryOfChiefComplaints::findOrFail($id);
        $chiefComplaints->complaint_name = $validatedData['complaint_name'];
        $chiefComplaints->status = $validatedData['status'];
        $chiefComplaints->updated_by = Auth::id();
        $chiefComplaints->save();
        return redirect()->route('chief-complaints.index')->with('success', 'Complaints updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\HistoryOfChiefComplaints  $historyOfChiefComplaints
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $del = HistoryOfChiefComplaints::findOrFail($id);
        $del->delete();
        return redirect()->route('chief-complaints.index')->with('success', 'Complaints Delete Successfully.');
    }
}
