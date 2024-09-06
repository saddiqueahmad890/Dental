<?php

namespace App\Http\Controllers;

use App\Models\DdExamination;
use App\Models\UserLogs;
use Illuminate\Http\Request;

class DdExaminationController extends Controller
{
    public function index(Request $request)
    {

        $examinations = $this->filter($request)->orderBy('id', 'desc')->paginate(10);
        return view('dd-examinations.index', compact('examinations'));
    }
    private function filter(Request $request)
    {
        $query = DdExamination::query();

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
        return view('dd-examinations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);
        $data = $request->all();
        $data['created_by'] = auth()->id();

        $examination=DdExamination::create($data);

        return redirect()->route('dd-examinations.edit',$examination->id)
            ->with('success', 'Examination created successfully.');
    }
    public function edit($id)
    {
        $examination = DdExamination::findOrFail($id);

        return view('dd-examinations.edit', compact('examination'));
    }


    public function show(DdExamination $dd_examination)
    {
        return view('dd-examinations.show', compact('dd_examination'));
    }
    public function update(Request $request, DdExamination $dd_examination)
    {

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);
        $data = $request->all();
        $data['updated_by'] = auth()->id();

        $dd_examination->update($data);

        return redirect()->route('dd-examinations.edit', $dd_examination->id)
            ->with('success', 'Examination updated successfully.');
    }



    public function destroy(DdExamination $dd_examination)
    {
        $dd_examination->delete();

        return redirect()->route('dd-examinations.index')
            ->with('success', 'Examination deleted successfully.');
    }
}
