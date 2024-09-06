@extends('layouts.layout')

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
                        <li class="breadcrumb-item active">Add New Task</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">Add New Task</h3>
                </div>
                <div class="card-body">
                    <form id="taskForm" class="bg-custom" action="{{ route('tasks.store') }}" method="POST" data-parsley-validate>
                        @csrf
                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="assign_to">Assign To:<b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <select name="assign_to" id="assign_to" class="form-control select2" required data-parsley-required="true"
                                        data-parsley-required-message="Please select doctor.">
                                            <option value="">Select</option>
                                            @foreach ($users as $doctor)
                                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="title">Title:<b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-file"></i></span>
                                        </div>
                                        <input type="text" id="title" name="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            value="{{ old('title') }}" required
                                            data-parsley-required="true"
                                            data-parsley-required-message="Please enter task title.">
                                    </div>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="due_date">@lang('Due Date')<b class="text-danger">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                        </div>
                                        <input type="text" name="due_date" id="due_date"
                                            class="form-control flatpickr @error('due_date') is-invalid @enderror"
                                            placeholder="@lang('Due Date')" value="{{ old('due_date') }}" required
                                            data-parsley-required="true"
                                            data-parsley-required-message="Please select date.">
                                        @error('due_date')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="task_action_id">Task Action:<b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-list"></i></span>
                                        </div>
                                        <select name="task_action_id" id="task_action_id" class="form-control select2" required data-parsley-required="true"
                                        data-parsley-required-message="Please select task action.">
                                            <option value="">Select an action</option>
                                            @foreach ($taskActions as $action)
                                                <option value="{{ $action->id }}">{{ $action->title }}</option>
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
                                    <label for="task_type_id">Task Type:<b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-code"></i></span>
                                        </div>
                                        <select name="task_type_id" id="task_type_id" class="form-control select2" required data-parsley-required="true"
                                        data-parsley-required-message="Please select task type.">
                                            <option value="">Select a type</option>
                                            @foreach ($taskTypes as $type)
                                                <option value="{{ $type->id }}">{{ $type->title }}</option>
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
                                    <label for="task_priority_id">Task Priority:<b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-thermometer-half"></i></span>
                                        </div>
                                        <select name="task_priority_id" id="task_priority_id" class="form-control select2" required data-parsley-required="true"
                                        data-parsley-required-message="Please select task prority.">
                                            <option value="">Select priority</option>
                                            @foreach ($taskPriorities as $priority)
                                                <option value="{{ $priority->id }}">{{ $priority->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('task_priority_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row col-12 m-0 p-0">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="task_status_id">Task Status:<b class="text-danger">*</b></label>
                                    <div class="form-group input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-bell"></i></span>
                                        </div>
                                        <select name="task_status_id" id="task_status_id" class="form-control select2" required data-parsley-required="true"
                                        data-parsley-required-message="Please select task status.">
                                            <option value="">Select status</option>
                                            @foreach ($taskStatuses as $status)
                                                <option value="{{ $status->id }}">{{ $status->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('task_status_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="description">Description:</label>
                                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" >{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-outline btn-info btn-lg mb-2 ml-2">Submit</button>
                        <a href="{{ route('tasks.index') }}" class="btn btn-outline btn-warning btn-lg mb-2">Cancel</a>
                    </form>


                </div>
            </div>
        </div>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var today = new Date();
        var tomorrow = new Date();
        tomorrow.setDate(today.getDate() + 1);

        flatpickr("#due_date", {
            defaultDate: tomorrow,
            minDate: tomorrow,
            dateFormat: "Y-m-d",
            disableMobile: true, // Optional: Disables mobile optimizations
            allowInput: true // Optional: Allows manual input, if desired
        });
    });
</script>
@endsection
