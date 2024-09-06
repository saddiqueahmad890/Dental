<?php

namespace App\Http\Controllers;

use App\Models\IntraOral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IntraOralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orals = IntraOral::paginate(10)->withQueryString();
        return view('intra-oral.index',compact('orals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('intra-oral.create');
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
            'intra_oral_name' => 'required|string|max:255',
            'status' => 'required'
        ]);
        $chiefComplaints = new IntraOral();
        $chiefComplaints->intra_oral_name = $validatedData['intra_oral_name'];
        $chiefComplaints->status = $validatedData['status'];
        $chiefComplaints->created_by = Auth::id();
        $chiefComplaints->save();
        return redirect()->route('intra-orals.index')->with('success', 'Intra Oral Saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\IntraOral  $intraOral
     * @return \Illuminate\Http\Response
     */
    public function show(IntraOral $intraOral)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\IntraOral  $intraOral
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $oral = IntraOral::find($id);
        return view('intra-oral.edit',compact('oral'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\IntraOral  $intraOral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'intra_oral_name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $chiefComplaints = IntraOral::findOrFail($id);
        $chiefComplaints->intra_oral_name = $validatedData['intra_oral_name'];
        $chiefComplaints->status = $validatedData['status'];
        $chiefComplaints->updated_by = Auth::id();
        $chiefComplaints->save();
        return redirect()->route('intra-orals.index')->with('success', 'Intra Oral updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\IntraOral  $intraOral
     * @return \Illuminate\Http\Response
     */
    public function destroy(IntraOral $intraOral)
    {
        $intraOral->delete();
        return redirect()->route('intra-orals.index')->with('success', 'Intra Oral Delete successfully.');
    }
}
