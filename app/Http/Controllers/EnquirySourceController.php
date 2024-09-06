<?php

namespace App\Http\Controllers;

use App\Models\EnquirySource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnquirySourceController extends Controller
{
    public function index()
    {
         
        $enquirysource = EnquirySource::orderBy('id', 'desc')->paginate(10);
        return view('dd-enquirysource.index', compact('enquirysource' ));
    }

    public function create()
    {
        return view('dd-enquirysource.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'source_name' => 'required|max:255',
        ]);

        $enquirysource = new EnquirySource();
        $enquirysource->source_name = $request->input('source_name');
        $enquirysource->created_by = Auth::id();
        $enquirysource->save();

        return redirect()->route('dd-enquirysource.index')
            ->with('success', 'Enquiry source created successfully.');
    }

    public function edit($id)
    {
        $dd_enquiry_source = EnquirySource::findOrFail($id);
        return view('dd-enquirysource.edit', compact('dd_enquiry_source'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'source_name' => 'required|max:255',
        ]);

        $enquirysource = EnquirySource::findOrFail($id);
        $enquirysource->update([
            'source_name' => $request->source_name,
        ]);

        return redirect()->route('dd-enquirysource.index')
            ->with('success', 'Enquiry source updated successfully.');
    }
    public function show($id)
    {
        $enquirySource = EnquirySource::findOrFail($id);
        return view('dd-enquirysource.show', compact('enquirySource'));
    }


    public function destroy($id)
    {
        $enquirysource = EnquirySource::findOrFail($id);
        $enquirysource->delete();

        return redirect()->route('dd-enquirysource.index')
            ->with('success', 'Enquiry source deleted successfully.');
    }
}
