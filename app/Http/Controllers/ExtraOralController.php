<?php

namespace App\Http\Controllers;

use App\Models\ExtraOral;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExtraOralController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orals = ExtraOral::paginate(10)->withQueryString();
        return view('extra-oral.index',compact('orals'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('extra-oral.create');
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
            'extra_oral_name' => 'required|string|max:255',
            'status' => 'required'
        ]);
        $chiefComplaints = new ExtraOral();
        $chiefComplaints->extra_oral_name = $validatedData['extra_oral_name'];
        $chiefComplaints->status = $validatedData['status'];
        $chiefComplaints->created_by = Auth::id();
        $chiefComplaints->save();
        return redirect()->route('extra-orals.index')->with('success', 'Extra Oral Saved successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ExtraOral  $extraOral
     * @return \Illuminate\Http\Response
     */
    public function show(ExtraOral $extraOral)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ExtraOral  $extraOral
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $oral = ExtraOral::find($id);
        return view('extra-oral.edit',compact('oral'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ExtraOral  $extraOral
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'extra_oral_name' => 'required|string|max:255',
            'status' => 'required',
        ]);
        $chiefComplaints = ExtraOral::findOrFail($id);
        $chiefComplaints->extra_oral_name = $validatedData['extra_oral_name'];
        $chiefComplaints->status = $validatedData['status'];
        $chiefComplaints->updated_by = Auth::id();
        $chiefComplaints->save();
        return redirect()->route('extra-orals.index')->with('success', 'Extra Oral updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ExtraOral  $extraOral
     * @return \Illuminate\Http\Response
     */
    public function destroy(ExtraOral $extraOral)
    {
        $extraOral->destroy();
        return redirect()->route('extra-orals.index')->with('success', 'Extra Oral Deleted successfully.');
    }
}
