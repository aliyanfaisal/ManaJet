@extends('layouts.guest_app')

@section('content')

    <div class="container-fluid w-8" id="form_top">
        <div>
            <x-card
                title="Add tickets To &nbsp;<span class='text-primary fsize-2'>{{ Str::upper($project->project_name) }}</span>"
                tab1="<a href='{{ route('project.edit', ['project' => $project->id]) }}' class='btn btn-primary '>Go To Project</a>"
                classes="border border-info">

                <div class="container-fluid px-md-5">

                    <x-display-errors />

                    <x-display-form-errors />
                    <form enctype="multipart/form-data" autocomplete="off" class="needs-validation row" novalidate=""
                        method="post" action="{{ route('tickets.store') }}">
                        @csrf
                        <input type="text" hidden name="project_id" value="{{ $project->id }}">
                        <div class="col-md-12 order-md-1">
                            <div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="ticket_name">Ticket Name</label>
                                        <input type="text" class="form-control" name="ticket_name" id="ticket_name"
                                            placeholder="Ticket Title" value="{{ old('ticket_name') }}" required="">
                                        <div class="invalid-feedback">
                                            ticket name is required.
                                        </div>
                                    </div>
                                    <div class="col-md-3 mb-3">

                                        <label for="reference_task_id">Reference Task</label>
                                        <select class="custom-select d-block w-100" name="reference_task_id" id="reference_task_id"
                                            >
                                            <option value="">Choose...</option>
                                            @foreach ($tasks as $task)
                                                <option @selected(old('reference_task_id') == $task->id) value="{{ $task->id }}">
                                                    {{ $task->task_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a Reference Task.
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">

                                        <label for="ticket_deadline">Ticket Deadline</label>
                                        <input type="date" value="{{ old('ticket_deadline') }}" class="form-control"
                                            name="ticket_deadline" id="ticket_deadline" required>
                                        <div class="invalid-feedback">
                                            Please select a Deadline.
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-3">

                                        <label for="priority">Ticket Priority</label>
                                        <select class="form-control" name="priority" id="priority" required>
                                            <option value="">Select...</option>
                                            <option @selected(old('priority') == 'high') value="high">High</option>
                                            <option @selected(old('priority') == 'medium') value="medium">Medium</option>
                                            <option @selected(old('priority') == 'low') value="low">Low</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a Priority.
                                        </div>
                                    </div>
                                </div>



                                <div class="row">

                                    <div class="col-md-10 mb-3">
                                        <label for="ticket_description">Ticket Description</label>
                                        <textarea rows="7" class="form-control" name="ticket_description" id="ticket_description"
                                            placeholder="Summary of the ticket" required="">{{ old('ticket_description') }}</textarea>
                                        <div class="invalid-feedback">
                                            Invalid description.
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <label for="files">Attachments</label>
                                        <input type="file" multiple class="form-control"
                                            name="files[]" id="files">
                                        
                                    </div>

                                </div>
                                <div class="row">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Add Ticket</button>

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

