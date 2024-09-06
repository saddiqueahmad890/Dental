@extends('layouts.layout')
<style>
    .text-right {
        text-align: right;
    }

    .text-left {
        text-align: left;
    }

    .card-header .d-flex {
        display: flex;
        align-items: center;
    }

    .card-header img {
        margin-right: 10px;
    }

    .card {
        border-radius: 15px;
        padding: 0px;
    }

    .mb-0 {
        margin-bottom: 0 !important;
    }

    .mb-3 {
        margin-bottom: 1rem !important;
    }
</style>

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3><a href="{{ route('tasks.index') }}" class="btn btn-outline btn-info"><i class="fas fa-eye"></i> View
                            All</a></h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('tasks.index') }}">All Tasks</a></li>
                        <li class="breadcrumb-item active">View Task</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-8">
            <div class="card p-0">
                <div class="card-header bg-info">
                    <h3 class="card-title">View Task</h3>
                </div>
                <div class="card-body">
                    <form class="bg-custom" id="taskForm" action="{{ route('tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row py-2 p-0 m-0">
                            <div class="col-md-4 py-3">
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <p id="title">{{ old('title', $task->title) }}</p>
                                </div>
                            </div>
                            <div class="col-md-8 py-3">
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <p id="description">{{ old('description', $task->description) }}</p>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4 py-3">
                                <div class="form-group">
                                    <label for="assign_to">Assign To:</label>
                                    <p id="assign_to">
                                        {{ $task->assign_to ? $users->firstWhere('id', $task->assign_to)->name : 'N/A' }}
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4 py-3">
                                <div class="form-group">
                                    <label for="due_date">@lang('Due Date')</label>
                                    <p id="due_date">{{ old('due_date', $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d-M-Y') : '-') }}</p>

                                </div>
                            </div>
                            <div class="col-md-4 py-3">
                                <div class="form-group">
                                    <label for="task_type_id">Task Action:</label>
                                    <p id="task_type_id">{{ $taskActions->firstWhere('id', $task->task_action_id)->title }}
                                    </p>
                                </div>
                            </div>

                            <div class="col-md-4 py-3">
                                <div class="form-group">
                                    <label for="task_type_id">Task Type:</label>
                                    <p id="task_type_id">{{ $taskTypes->firstWhere('id', $task->task_type_id)->title }}</p>
                                </div>
                            </div>

                            <div class="col-md-4 py-3">
                                <div class="form-group">
                                    <label for="task_priority_id">Task Priority:</label>
                                    <p id="task_priority_id">
                                        {{ $taskPriorities->firstWhere('id', $task->task_priority_id)->title }}</p>
                                </div>
                            </div>
                            <div class="col-md-4 py-3">
                                <div class="form-group">
                                    <label for="task_status">Task Status:</label>
                                    <select name="task_status" id="task_status" class="form-control select2" required>
                                        @foreach ($taskStatuses as $status)
                                            <option value="{{ $status->id }}"
                                                {{ $task->task_status_id == $status->id ? 'selected' : '' }}>
                                                {{ $status->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('task_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-md-4 ">
            <div class="card p-0">
             <div class="card-header bg-info">
                    <h3 class="card-title">Chat</h3>
                </div>
                <div class="card-body p-0" style="display: flex; flex-direction: column; height: 410;">
                    <div style="flex-grow: 1; overflow-y: auto; padding: 15px 2px;">
                        <ul class="list-unstyled">
                            @foreach ($chats as $chat)
                                @php
                                    $isSender = $chat->user_id == auth()->user()->id;
                                @endphp

                                <li class="mb-3 {{ $isSender ? 'text-right' : 'text-left' }}">
                                    <div class="card">
                                        <div class="card-header bg-info d-flex justify-content-between bg-light pl-0 ml-0">
                                            <div class="d-flex align-items-center">
                                                @if ($chat->user->photo !== null)
                                                    <img src="{{ asset($chat->user->photo) }}" alt="User Image"
                                                        class="rounded-circle" width="35" height="40">
                                                @else
                                                    <img src="{{ $defaultImagePath }}" alt="Default Profile Picture"
                                                        class="profile-user-img img-fluid rounded-circle"
                                                        style="width: 35px; height: 40px; object-fit: cover;">
                                                @endif
                                                <p class="fw-bold mb-0 fs-4" style="padding-right: 40px">
                                                    <small>{{ $chat->user->name }}</small>
                                                </p>

                                            <p class="text-muted small mb-0" style="padding-left:99px;">
                                                <i class="far fa-clock"></i>
                                                <small><small>{{ $chat->created_at->format('H:i') }}</small></small>
                                            </p>
                                        </div>
                                        </div>
                                        <div class="card-body">
                                            <p class="mb-0">{{ $chat->message }}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <div class="d-flex align-items-center" style="padding: 15px; border-top: 1px solid #dee2e6;">
                        <form method="post" action="{{ route('chats.store') }}" class="w-100 d-flex">
                            @csrf
                            <input type="hidden" name="task_id" value="{{ $task->id }}">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <div class="form-group flex-grow-1 mb-0">
                                <textarea class="form-control" name="message" rows="2" placeholder="Type your message here..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-info btn-sm">
                                <i class="fas fa-paper-plane fa-sm"></i>
                            </button>

                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-12">
            @canany(['userlog-read'])
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">
                        User Logs
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Action</th>
                                <th>Table</th>
                                <th>Column</th>
                                <th>Old Value</th>
                                <th>New Value</th>
                                <th>Timestamp</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $log)
                                <tr>
                                    <td><span>{{ $log->user->id }}</span></td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ $log->table_name }}</td>
                                    <td>{{ $log->field_name }}</td>
                                    <td>{{ $log->old_value }}</td>
                                    <td>{{ $log->new_value }}</td>
                                    <td>{{ $log->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endcanany
        </div>

    </div>
    <script>
        $(document).ready(function() {
            $('#task_status').on('change', function() {
                var statusId = $(this).val();
                var taskId = {{ $task->id }};

                $.ajax({
                    url: '{{ route('tasks.updateStatus') }}',
                    type: 'POST',
                    data: {
                        status_id: statusId,
                        task_id: taskId,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert("Status updated successfully");

                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                    }
                });
            });
        });
    </script>
@endsection
