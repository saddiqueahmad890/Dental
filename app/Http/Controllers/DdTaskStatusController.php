<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DdTaskStatus;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogs;

class DdTaskStatusController extends Controller
{
    public function index(Request $request)
    {
        $ddTaskStatus = $this->filter($request)->orderBy('id', 'desc')->get();
        return view('dd-task-status.index', compact('ddTaskStatus'));
    }

    private function filter(Request $request)
    {
        $query = DdTaskStatus::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }


        return $query;
    }
    public function create()
    {
        return view('dd-task-status.create');
    }

    public function store(Request $request)
    {
        $this->validation($request);

        $taskStatusData = $request->only(['title', 'description']);
        $taskStatusData['created_by'] = Auth::id();

        $taskStatus = new DdTaskStatus($taskStatusData);
        $taskStatus->save();
        $ddTaskStatusId = $taskStatus->id;

        return redirect()->route('dd-task-status.edit', $ddTaskStatusId)->with('success', trans('Task status added successfully'));
    }

    public function show(DdTaskStatus $ddTaskStatus)
    {
        return view('dd-task-status.show', compact('ddTaskStatus'));
    }

    public function edit(DdTaskStatus $ddTaskStatus)
    {
        $tableName = "dd_task_status";

        return view('dd-task-status.edit', compact('ddTaskStatus'));
    }

    public function update(Request $request, DdTaskStatus $ddTaskStatus)
    {
        $this->validation($request);

        $data = $request->all();
        $data['updated_by'] = Auth::id();
        $ddTaskStatus->update($data);
        return redirect()->route('dd-task-status.edit', $ddTaskStatus)->with('success', 'Task status updated successfully.');
    }

    public function destroy(DdTaskStatus $ddTaskStatus)
    {
        $ddTaskStatus->delete();
        return redirect()->route('dd-task-status.index')->with('success', trans('Task status deleted successfully'));
    }

    private function validation(Request $request, $id = 0)
    {


        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:255',


        ]);
    }
}
