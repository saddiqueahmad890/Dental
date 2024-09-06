<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DdTaskType;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogs;

class DdTaskTypeController extends Controller
{
    public function index(Request $request)
    {
        $ddTaskTypes = $this->filter($request)->orderBy('id', 'desc')->get();
        return view('dd-task-type.index', compact('ddTaskTypes'));
    }

    private function filter(Request $request)
    {
        $query = DdTaskType::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }


        return $query;
    }

    public function create()
    {
        return view('dd-task-type.create');
    }

    public function store(Request $request)
    {
        $this->validation($request);

        $taskTypeData = $request->only(['title', 'description']);
        $taskTypeData['created_by'] = Auth::id();

        $taskType = new DdTaskType($taskTypeData);
        $taskType->save();
        $ddTaskTypeId = $taskType->id;

        return redirect()->route('dd-task-type.edit', $ddTaskTypeId)->with('success', trans('Task type added successfully'));
    }

    public function show(DdTaskType $ddTaskType)
    {
        return view('dd-task-type.show', compact('ddTaskType'));
    }

    public function edit(DdTaskType $ddTaskType)
    {
        $tableName = "dd_task_types";

        return view('dd-task-type.edit', compact('ddTaskType'));
    }

    public function update(Request $request, DdTaskType $ddTaskType)
    {
        $this->validation($request);

        $data = $request->all();
        $data['updated_by'] = Auth::id();
        $ddTaskType->update($data);
        return redirect()->route('dd-task-type.edit', $ddTaskType)->with('success', 'Task type updated successfully.');
    }

    public function destroy(DdTaskType $ddTaskType)
    {
        $ddTaskType->delete();
        return redirect()->route('dd-task-type.index')->with('success', trans('Task type deleted successfully'));
    }

    private function validation(Request $request, $id = 0)
    {


        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:255',


        ]);
    }
}
