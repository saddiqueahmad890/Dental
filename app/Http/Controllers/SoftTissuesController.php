<?php

namespace App\Http\Controllers;

use App\Models\SoftTissues;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SoftTissuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orals = SoftTissues::paginate(10)->withQueryString();
        return view('soft-tissue.index',compact('orals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('soft-tissue.create');
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
            'soft_tissues_name' => 'required|string|max:255',
            'status' => 'required'
        ]);
        $chiefComplaints = new SoftTissues();
        $chiefComplaints->soft_tissues_name = $validatedData['soft_tissues_name'];
        $chiefComplaints->status = $validatedData['status'];
        $chiefComplaints->created_by = Auth::id();
        $chiefComplaints->save();
        return redirect()->route('soft-tissues.index')->with('success', 'Soft Tissue Saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SoftTissues  $softTissues
     * @return \Illuminate\Http\Response
     */
    public function show(SoftTissues $softTissues)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SoftTissues  $softTissues
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $oral = SoftTissues::find($id);
        return view('soft-tissue.edit',compact('oral'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SoftTissues  $softTissues
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'soft_tissues_name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $chiefComplaints = SoftTissues::findOrFail($id);
        $chiefComplaints->soft_tissues_name = $validatedData['soft_tissues_name'];
        $chiefComplaints->status = $validatedData['status'];
        $chiefComplaints->updated_by = Auth::id();
        $chiefComplaints->save();
        return redirect()->route('soft-tissues.index')->with('success', 'Soft Tissue updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SoftTissues  $softTissues
     * @return \Illuminate\Http\Response
     */
    public function destroy(SoftTissues $softTissues)
    {
        $softTissues->delete();
        return redirect()->route('soft-tissues.index')->with('success', 'Soft Tissue Delete successfully.');
    }
}
