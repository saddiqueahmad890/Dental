<?php

namespace App\Http\Controllers;
use App\Models\UserLogs;
use App\Traits\Loggable;
use App\Models\Task;
use App\Models\Event;

use App\Models\User;
use App\Models\Chat;
use App\Models\TaskNotification;
use App\Models\DdTaskAction;
use App\Models\DdTaskStatus;
use App\Models\DdTaskType;
use App\Models\DdTaskPriority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\GenericExport;
use Maatwebsite\Excel\Facades\Excel;


class TaskController extends Controller
{
    use loggable;
    public function filter(Request $request)
    {
        $query = Task::query();

        if ($request->has('title') && !empty($request->title)) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }


        if ($request->has('assign_by') && !empty($request->assign_by)) {
            $query->whereHas('assignBy', function ($subquery) use ($request) {
                $subquery->where('name', 'like', '%' . $request->assign_by . '%');
            });
        }

        if ($request->has('assign_to') && !empty($request->assign_to)) {
            $query->whereHas('assignTo', function ($subquery) use ($request) {
                $subquery->where('name', 'like', '%' . $request->assign_to . '%');
            });
        }
        return $query;
    }

    public function index(Request $request)
    {
        if ($request->has('export') && $request->export) {
            return $this->doExport($request);
        }

        $query = $this->filter($request)->orderBy('created_at', 'desc');
        $user = auth()->user();


        if (!auth()->user()->hasRole('Super Admin')) {
            $query->where('assign_to', $user->id);
        }
        $tasks = $query->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    private function doExport(Request $request)
    {
        // Retrieve filtered data
        $tasks = $this->filter($request)->get();

        // Prepare data for export
        $data = $tasks->map(function ($task) {
            return [
                $task->id,
                $task->title,
                $task->description,
                optional($task->assignTo)->name,
                optional($task->assignBy)->name,
                optional($task->taskPriority)->title,
                optional($task->taskStatus)->title,
                optional($task->taskAction)->title,
                optional($task->taskType)->title,
                $task->status == '1' ? 'Active' : 'Inactive',
                $task->created_at,
                $task->updated_at,
            ];
        })->toArray();

        // Define headers for the export
        $headers = ['ID', 'Title', 'Description', 'Assign To', 'Assign By', 'Priority', 'Status', 'Action', 'Type', 'Status', 'Created At', 'Updated At'];

        return Excel::download(new GenericExport($data, $headers), 'Tasks.xlsx');
    }

    public function create()
    {

        $authUserId = Auth::id();


        $users = User::whereNotIn('id', [$authUserId])->get();
        $taskActions = DdTaskAction::all();
        $taskTypes = DdTaskType::all();
        $taskPriorities = DdTaskPriority::all();
        $taskStatuses = DdTaskStatus::all();

        return view('tasks.create', compact('users', 'taskActions', 'taskTypes', 'taskPriorities', 'taskStatuses'));
    }


    public function store(Request $request)
    {
        $this->validation($request);
        $data = $request->only(['assign_to', 'title', 'description', 'due_date', 'task_action_id', 'task_type_id', 'task_priority_id', 'task_status_id', 'status']);
        $data['assign_by'] = auth()->id();

        $task = Task::create($data);

        if ($task) {
            TaskNotification::create([
                'assign_by' => Auth::id(),
                'assign_to' => $data['assign_to'],
                'text' => 'New Task is assigned to you by ' . Auth::user()->name,
                'url' => route('tasks.show', $task->id),
                'status' => 'new',
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);
             // Create or update calendar event
        $eventData = [
            'title' => 'Task: ' . $task->title,
            'description' => $task->description,
            'start_date' => now()->toDateString(),
            'end_date' => $task->due_date,
            'eventtype' => 'task', // Set the eventtype
            'task_assign_to' => $task->assign_to, // Set the eventtype
        ];
        Event::updateOrCreate(['id' => $task->id], $eventData);
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function show(Task $task)
    {
        $users = User::all();
        $taskActions = DdTaskAction::all();
        $taskTypes = DdTaskType::all();
        $taskPriorities = DdTaskPriority::all();
        $taskStatuses = DdTaskStatus::all();
        $chats = Chat::where('task_id', $task->id)->orderBy('created_at', 'asc')->get();
        $defaultImagePath = 'alu/male.png';
        //start log code
        $logs = UserLogs::where('table_name', 'tasks')->orderBy('id', 'desc')
        ->with('user')
        ->paginate(10);
        //end log code
        return view('tasks.show', compact('users', 'task', 'defaultImagePath', 'chats', 'taskActions', 'taskTypes', 'taskPriorities', 'taskStatuses','logs'));

    }

    public function fetchTaskNotifications()
    {
        $notifications = TaskNotification::where('assign_to', Auth::id())->get()->all();
        $countTaskNotification = TaskNotification::where('status', 'new')->where('assign_to', Auth::id())->count();
        return response()->json([
            'notifications' => $notifications,
            'countTaskNotification' => $countTaskNotification
        ]);
    }

    // Mark task notification as read
    public function markTaskNotificationAsRead(Request $request)
    {
        $notification = TaskNotification::find($request->notificationId);
        if ($notification && $notification->assign_to == Auth::id()) {
            $notification->status = 'read';
            $notification->save();
        }
        return response()->json(['success' => true]);
    }


    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }


    private function validation(Request $request, $id = 0)
    {


        $request->validate([
            'assign_to' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date',
            'task_action_id' => 'required|int|exists:dd_task_actions,id',
            'task_type_id' => 'required|int|exists:dd_task_types,id',
            'task_priority_id' => 'required|int|exists:dd_task_priorities,id',

        ]);
    }


    public function updateStatus(Request $request)
    {
        $task = Task::findOrFail($request->task_id);
        $task->task_status_id = $request->status_id;
        $task->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }

}
