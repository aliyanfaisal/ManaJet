@extends('layouts.superadmin_app')

@section('content')
    <div class="container-fluid w-8">
        <div>
            <x-card title="Edit Task &nbsp;<span class='text-primary fsize-2'>{{ Str::upper($task->task_name) }}</span>"
                tab1="<a href='{{ route('project.edit', ['project' => $task->project->id]) }}' class='btn btn-primary '>Go To Project</a>"
                classes="border border-info">

                <div class="container-fluid px-md-5">

                    <x-display-errors />

                    <x-display-form-errors />
                    <form enctype="multipart/form-data" autocomplete="off" class="needs-validation row" novalidate=""
                        method="post" action="{{ route('tasks.update', ['task' => $task->id]) }}">
                        @csrf
                        @method("PATCH")
                        <div class="col-md-12 order-md-1">
                            <div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="task_name">Task Name</label>
                                        <input type="text" class="form-control" name="task_name" id="task_name"
                                            placeholder="Task Title" value="{{ $task->task_name }}" required="">
                                        <div class="invalid-feedback">
                                            Task name is required.
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">

                                        <label for="task_lead_id">Task Lead</label>
                                        <select class="custom-select d-block w-100" name="task_lead_id" id="task_lead_id"
                                            required="">
                                            <option value="">Choose...</option>
                                            @foreach ($team_members as $mem)
                                                <option @selected($task->task_lead_id == $mem->id) value="{{ $mem->id }}">
                                                    {{ $mem->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a Task Lead.
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">

                                        <label for="task_deadline">Task Deadline</label>
                                        <input type="date" value="{{ $task->task_deadline }}" class="form-control"
                                            name="task_deadline" id="task_deadline" required>
                                        <div class="invalid-feedback">
                                            Please select a Deadline.
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-3">

                                        <label for="priority">Task Priority</label>
                                        <select class="form-control" name="priority" id="priority" required>
                                            <option value="">Select...</option>
                                            <option @selected($task->priority == 'high') value="high">High</option>
                                            <option @selected($task->priority == 'medium') value="medium">Medium</option>
                                            <option @selected($task->priority == 'low') value="low">Low</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a Priority.
                                        </div>
                                    </div>
                                </div>




                                <div class="row">

                                    <div class="col-md-10 mb-3">
                                        <label for="task_description">Task Description</label>
                                        <textarea rows="7" class="form-control" name="task_description" id="task_description"
                                            placeholder="Summary of the Task" required="">{{ $task->task_description }}</textarea>
                                        <div class="invalid-feedback">
                                            Invalid description.
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-3">

                                        <div class="mb-3">
                                            <label for="task_step_no">Step No. <span
                                                class="text-muted">(optional)</span></label>
                                        <input type="number" placeholder="Step Number" class="form-control"
                                            name="task_step_no" id="task_step_no">

                                        <div class="invalid-feedback">
                                            Please select a Deadline.
                                        </div>
                                        </div>
                                        <div>
                                            <label for="status">Status</label>
                                                
                                        <select class="form-control" name="status" id="status">
                                            <option value="pending" @selected($task->status=="pending")>Pending</option>
                                            <option value="under-review" @selected($task->status=="under-review")>Under Review</option> 
                                            <option value="complete" @selected($task->status=="complete")>Complete</option>
                                        
                                            </select>

                                        <div class="invalid-feedback">
                                            Please select a Deadline.
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Update Task</button>
                                </div>

                            </div>
                        </div>
                    </form>

                </div>

            </x-card>


        </div>
    </div>


    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();
    </script>
@endsection



@section('js')
    <script>
        var selectedDate = new Date('<?php echo $task->task_deadline; ?>');

        var day = ("0" + selectedDate.getDate()).slice(-2);
        var month = ("0" + (selectedDate.getMonth() + 1)).slice(-2);

        var today = selectedDate.getFullYear()+"-"+(month)+"-"+(day) ;

        $("#task_deadline").val(today)
    </script>
@endsection
