<?php

namespace App\Http\Controllers;
use App\Models\UserLogs;
use App\Models\DdInvestigation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DdInvestigationController extends Controller
{
    public function index(Request $request)
    {

        $ddInvestigations = $this->filter($request)->orderBy('id', 'desc')->paginate(10);
        return view('dd-investigations.index', compact('ddInvestigations'));
    }
    private function filter(Request $request)
    {
        $query = DdInvestigation::query();

        if ($request->has('title') && $request->title) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->has('description') && $request->description) {
            $query->where('description', 'like', '%' . $request->description . '%');
        }

        return $query;
    }


    public function create()
    {
        return view('dd-investigations.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
        ]);

        $treatmentplan = new DdInvestigation();
        $treatmentplan->title = $request->input('title');
        $treatmentplan->description = $request->input('description');
        $treatmentplan->created_by = Auth::id();
        $treatmentplan->save();

        $dd_investigation=$treatmentplan ->id;

        return redirect()->route('dd-investigations.edit',$dd_investigation)
            ->with('success', 'Investigation created successfully.');
    }
    public function edit(DdInvestigation  $dd_investigation)
    {

        return view('dd-investigations.edit', compact('dd_investigation'));
    }


    public function show(DdInvestigation $dd_investigation)
    {
        return view('dd-investigations.show', compact('dd_investigation'));
    }
    public function update(Request $request, DdInvestigation $dd_investigation)
    {

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);
        $data = $request->all();
        $data['updated_by'] = auth()->id();
        $dd_investigation->update($data);

         return redirect()->route('dd-investigations.edit',$dd_investigation)
            ->with('success', 'Investigation updated successfully.');
    }



    public function destroy(DdInvestigation $dd_investigation)
    {
        $dd_investigation->delete();

        return redirect()->route('dd-investigations.index')
            ->with('success', 'Investigation deleted successfully.');
    }
}
