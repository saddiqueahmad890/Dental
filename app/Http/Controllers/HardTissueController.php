<?php

namespace App\Http\Controllers;

use App\Models\HardTissue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HardTissueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orals = HardTissue::paginate(10)->withQueryString();
        return view('hard-tissue.index',compact('orals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('hard-tissue.create');
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
            'hard_tissue_name' => 'required|string|max:255',
            'status' => 'required'
        ]);
        $chiefComplaints = new HardTissue();
        $chiefComplaints->hard_tissue_name = $validatedData['hard_tissue_name'];
        $chiefComplaints->status = $validatedData['status'];
        $chiefComplaints->created_by = Auth::id();
        $chiefComplaints->save();
        return redirect()->route('hard-tissues.index')->with('success', 'Hard Tissue Saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\HardTissue  $hardTissue
     * @return \Illuminate\Http\Response
     */
    public function show(HardTissue $hardTissue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\HardTissue  $hardTissue
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $oral = HardTissue::find($id);
        return view('hard-tissue.edit',compact('oral'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\HardTissue  $hardTissue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'hard_tissue_name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $chiefComplaints = HardTissue::findOrFail($id);
        $chiefComplaints->hard_tissue_name = $validatedData['hard_tissue_name'];
        $chiefComplaints->status = $validatedData['status'];
        $chiefComplaints->updated_by = Auth::id();
        $chiefComplaints->save();
        return redirect()->route('hard-tissues.index')->with('success', 'Hard Tissue updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SoftTissues  $softTissues
     * @return \Illuminate\Http\Response
     */
    public function destroy(HardTissue $softTissues)
    {
        $softTissues->delete();
        return redirect()->route('hard-tissue.index')->with('success', 'Hard Tissue Delete successfully.');
    }
}
