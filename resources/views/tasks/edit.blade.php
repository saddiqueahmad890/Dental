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
        padding: 10px;
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
                            All</a>
                        <span class="pull-right"></span>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('tasks.index') }}">All Tasks</a>
                        </li>
                        <li class="breadcrumb-item active">Edit Task</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Edit Task</h3>
                </div>
                <div class="card-body">
                    <form id="taskForm" action="{{ route('tasks.update', $task->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="assign_to">Assign To:</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                    <p id="assign_to">
                                        {{ $task->assign_to ? $users->firstWhere('id', $task->assign_to)->name : 'N/A' }}
                                    </p>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Title:</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file"></i></span>
                                        </div>
                                    <input type="text" id="title" name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        value="{{ old('title', $task->title) }}" required>
                                    </div>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="due_date">@lang('Due Date')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                        </div>
                                        <input type="text" name="due_date" id="due_date"
                                            class="form-control flatpickr @error('due_date') is-invalid @enderror"
                                            value="{{ old('due_date', $task->due_date) }}">
                                        @error('due_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="task_action_id">Task Action:</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                                        </div>
                                    <select name="task_action_id" id="task_action_id" class="form-control select2" required>
                                        @foreach ($taskActions as $action)
                                            <option value="{{ $action->id }}"
                                                {{ $task->task_action_id == $action->id ? 'selected' : '' }}>
                                                {{ $action->title }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    @error('task_action_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="task_type_id">Task Type:</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-code"></i></span>
                                        </div>
                                    <select name="task_type_id" id="task_type_id" class="form-control select2" required>
                                        @foreach ($taskTypes as $type)
                                            <option value="{{ $type->id }}"
                                                {{ $task->task_type_id == $type->id ? 'selected' : '' }}>
                                                {{ $type->title }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    @error('task_type_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="task_priority_id">Task Priority:</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-thermometer-half"></i></span>
                                        </div>
                                    <select name="task_priority_id" id="task_priority_id" class="form-control select2"
                                        required>
                                        @foreach ($taskPriorities as $priority)
                                            <option value="{{ $priority->id }}"
                                                {{ $task->task_priority_id == $priority->id ? 'selected' : '' }}>
                                                {{ $priority->title }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                    @error('task_priority_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="task_status">Task Status:</label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-bell"></i></span>
                                        </div>
                                    <select name="task_status" id="task_status" class="form-control select2" required>
                                        @foreach ($taskStatuses as $status)
                                            <option value="{{ $status->id }}"
                                                {{ $task->status == $status->id ? 'selected' : '' }}>{{ $status->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                    </div>
                                    @error('task_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $task->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-outline btn-info btn-lg">Update</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline btn-warning btn-lg">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Chat</h3>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        @foreach ($chats as $chat)
                            @php
                                $isSender = $chat->user_id == auth()->user()->id;
                            @endphp

                            <li class="mb-3 {{ $isSender ? 'text-right' : 'text-left' }}">
                                <div class="card">
                                    <div class="card-header bg-info d-flex justify-content-between">
                                        <div class="d-flex align-items-center">
                                            @if ($chat->user->photo !== null)
                                                <img src="{{ asset($chat->user->photo) }}" alt="User Image"
                                                    class="rounded-circle" width="40" height="40">
                                            @else
                                                <img src="{{ $defaultImagePath }}" alt="Default Profile Picture"
                                                    class="profile-user-img img-fluid rounded-circle"
                                                    style="width: 40px; height: 40px; object-fit: cover;">
                                            @endif
                                            <p class="fw-bold mb-0 ml-2">{{ $chat->user->name }}</p>
                                        </div>
                                        <p class="text-muted small mb-0"><i class="far fa-clock"></i>
                                            {{ $chat->created_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="card-body">
                                        <p class="mb-0">{{ $chat->message }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach

                    </ul>

                    <form method="post" action="{{ route('chats.store') }}">
                        @csrf
                        <input type="hidden" name="task_id" value="{{ $task->id }}">
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="form-group">
                            <textarea class="form-control" name="message" rows="3" placeholder="Type your message here..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
