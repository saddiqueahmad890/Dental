<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DdTaskAction;
use Illuminate\Support\Facades\Auth;
use App\Models\UserLogs;

class DdTaskActionController extends Controller
{
    public function index(Request $request)
    {
        $ddTaskActions = $this->filter($request)->orderBy('id', 'desc')->paginate(10);
        return view('dd-task-action.index', compact('ddTaskActions'));
    }

    private function filter(Request $request)
    {
        $query = DdTaskAction::query();

        // Apply filters based on request parameters
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        // Add more filters here as needed

        return $query;
    }

    public function create()
    {
        return view('dd-task-action.create');
    }

    public function store(Request $request)
    {
        $this->validation($request);

        $taskActionData = $request->only(['title', 'description']);
        $taskActionData['created_by'] = Auth::id();

        $taskAction = new DdTaskAction($taskActionData);
        $taskAction->save();
        $ddTaskActionId = $taskAction->id;

        return redirect()->route('dd-task-action.edit', $ddTaskActionId)->with('success', trans('Task action added successfully'));
    }

    public function show(DdTaskAction $ddTaskAction)
    {
        return view('dd-task-action.show', compact('ddTaskAction'));
    }

    public function edit(DdTaskAction $ddTaskAction)
    {
        $tableName = "dd_task_actions";

        return view('dd-task-action.edit', compact('ddTaskAction'));
    }

    public function update(Request $request, DdTaskAction $ddTaskAction)
    {
        $this->validation($request);

        $data = $request->all();
        $data['updated_by'] = Auth::id();
        $ddTaskAction->update($data);
        return redirect()->route('dd-task-action.edit', $ddTaskAction)->with('success', 'Task action updated successfully.');
    }

    public function destroy(DdTaskAction $ddTaskAction)
    {
        $ddTaskAction->delete();
        return redirect()->route('dd-task-action.index')->with('success', trans('Task action deleted successfully'));
    }

    private function validation(Request $request, $id = 0)
    {


        $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable|max:255',


        ]);
    }
}
