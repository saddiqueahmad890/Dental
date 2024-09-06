<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DdTaskPriority;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogs;

class DdTaskPriorityController extends Controller
{
    public function index(Request $request)
    {
        $ddTaskPrioritys = $this->filter($request)->orderBy('id', 'desc')->get();
        return view('dd-task-priority.index', compact('ddTaskPrioritys'));
    }

    private function filter(Request $request)
    {
        $query = DdTaskPriority::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }


        return $query;
    }
    public function create()
    {
        return view('dd-task-priority.create');
    }

    public function store(Request $request)
    {
        $this->validation($request);

        $taskPriorityData = $request->only(['title', 'description']);
        $taskPriorityData['created_by'] = Auth::id();

        $taskPriority = new DdTaskPriority($taskPriorityData);
        $taskPriority->save();
        $ddTaskPriorityId = $taskPriority->id;

        return redirect()->route('dd-task-priority.edit', $ddTaskPriorityId)->with('success', trans('Task priority added successfully'));
    }

    public function show(DdTaskPriority $ddTaskPriority)
    {
        return view('dd-task-priority.show', compact('ddTaskPriority'));
    }

    public function edit(DdTaskPriority $ddTaskPriority)
    {
        $tableName = "dd_task_prioritys";

        return view('dd-task-priority.edit', compact('ddTaskPriority'));
    }

    public function update(Request $request, DdTaskPriority $ddTaskPriority)
    {
        $this->validation($request);

        $data = $request->all();
        $data['updated_by'] = Auth::id();
        $ddTaskPriority->update($data);
        return redirect()->route('dd-task-priority.edit', $ddTaskPriority)->with('success', 'Task priority updated successfully.');
    }

    public function destroy(DdTaskPriority $ddTaskPriority)
    {
        $ddTaskPriority->delete();
        return redirect()->route('dd-task-priority.index')->with('success', trans('Task priority deleted successfully'));
    }

    private function validation(Request $request, $id = 0)
    {


        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:255',


        ]);
    }
}
