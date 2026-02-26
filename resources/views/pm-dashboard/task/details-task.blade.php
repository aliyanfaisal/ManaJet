@extends('layouts.superadmin_app')

@section('content')
    <div class="container-fluid w-8">




        <div>

            <x-card title="<h4><b>{{ $task->task_name }}</b></h4>" classes="border border-info">

                <div class="row px-4">
                    <div class="col-md-4 py-2 mb-3 border border-info"
                        style="display: flex;
                    flex-direction: column;
                    justify-content: center;">

                        <div class="text-center">

                            <div class="">
                                <h5 class="font-weight-bold">{{ $task->task_name }}</h5 class="font-weight-bold">
                                <p>
                                    {{ $task->task_description }}
                                </p>
                            </div>
                        </div>
                        <x-fancy-table classes="text-center">
                            <x-fancy-table-body>
                                <tr>
                                    <th>Priority</th>
                                    <th>
                                        <div class="badge fsize-1 badge-secondary">{{ $task->priority }}</div>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Lead</th>
                                    <th>
                                        <div class="badge fsize-1 badge-warning">{{ $task->taskLead->name }}</div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Team</th>
                                    <th>
                                        <div class="badge fsize-1 badge-warning">{{ $task->team()->team_name }}</div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Project</th>
                                    <th>
                                        <div class="badge fsize-1 badge-primary"> {{ $task->project->project_name }} </div>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Days Left</th>
                                    <th>
                                        @php
                                            $now = new DateTime();
                                            $then = new DateTime($task->task_deadline);

                                            $interval = $then->diff($now);

                                        @endphp
                                        <div class="badge fsize-1 badge-info">{{ $interval->days }} Day(s)</div>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <th>
                                        <div class="badge fsize-1 badge-danger">{{ $task->status }}</div>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Message</th>
                                    <th>
                                        <p class="text-muted">{{ $task->message($task->task_lead_id) }}</p>
                                    </th>
                                </tr>
                            </x-fancy-table-body>

                        </x-fancy-table>

                    </div>

                    <div class="col-md-8 mb-3 border ">
                        <x-card title="Submit Task" classes="border border-info">
                            @if ($task->status == 'pending')
                                <form class="needs-validation" novalidate="" method="post"
                                    action="{{ route('tasks.sendForVerification') }}">
                                    @csrf

                                    <div class="">

                                        <x-display-errors />

                                        <x-display-form-errors />
                                        <div>
                                            <input type="text" hidden name="task_id" value="{{ $task->id }}">
                                            <div>
                                                <label for="message">Message</label>
                                                <textarea class="form-control mb-3" name="message" id="message" rows="5">{{ old('cat_description') }}</textarea>
                                            </div>

                                            <button class="btn btn-primary btn-lg btn-block" type="submit">Submit
                                                Task</button>


                                        </div>
                                    </div>

                                </form>
                            @else
                                <div>
                                    <div class="alert alert-info text-center">Task Is Already
                                        {{ Str::upper($task->status) }}</div>
                                </div>
                            @endif
                        </x-card>
                    </div>
                </div>


                <x-card title="Attachments"  classes="border border-info">
                             
                               @php
                                $attachments= $task->attachments();
                               @endphp
                            
                            @foreach($attachments as $attach)

                            <a href='{{Storage::url("$attach->file_path")}}' download="">
                                <img class="img-fluid" style="max-width:300px"  src="{{Storage::url("$attach->file_path")}}">
                            </a>
                            @endforeach
                </x-card>



            </x-card>

        </div>
    </div>



    <div class="modal" tabindex="-1" id="edit_form_modal" data-bs-backdrop="false" style="top: 60px">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cat_title_modal">View Ticket</h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
                <div class="modal-body">
                    <div id="main_form">
                        @csrf
                        <input hidden name="id">
                        <x-card title="Add New Category" classes="border border-info">
                            <div class="">
                                <div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cat_name">Ticket Name</label>
                                            <input readonly type="text" class="form-control" name="ticket_name"
                                                id="ticket_name" placeholder="Category Name">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="cat_name">Description</label>
                                            <input readonly type="text" class="form-control" name="ticket_description"
                                                id="ticket_description" placeholder="Category Name">
                                        </div>

                                    </div>


                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cat_name">Ticket Name</label>
                                            <input readonly type="text" class="form-control" name="ticket_name"
                                                id="ticket_name" placeholder="Category Name">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="priority">Priority</label>
                                            <input readonly type="text" class="form-control" name="priority"
                                                id="priority" placeholder="Category Name">
                                        </div>

                                    </div>



                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cat_name">Reference Task</label>
                                            <input readonly type="text" class="form-control" name="reference_task_id"
                                                id="reference_task_id" placeholder="Category Name">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="status">Status</label>
                                            <input readonly type="text" class="form-control" name="status"
                                                id="status" placeholder="Category Name">
                                        </div>

                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="">Deadline</label>
                                            <input readonly type="text" class="form-control" name="task_deadline"
                                                id="task_deadline" placeholder="Category Name">
                                        </div>


                                    </div>

                                    <div>
                                        <label for="ticket_description">Ticket Description</label>
                                        <textarea readonly class="form-control mb-3" name="ticket_description" id="ticket_description" rows="5">{{ old('cat_description') }}</textarea>
                                    </div>



                                </div>


                            </div>
                        </x-card>
                        </form>


                    </div>
                </div>
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
            var myModal = new bootstrap.Modal(document.getElementById('edit_form_modal'), {
                keyboard: false
            })

            $(document).on("click", "#edit", function() {
                var $json = $(this).data("json")


                $("#cat_title_modal").html($json['role_name'])
                for ($field in $json) {
                    const ele = $("#main_form").find("[name='" + $field + "']")
                    console.log("json", ele)
                    if (ele.length > 0) {

                        if (ele.prop("tagName").toLowerCase() == "select" && ele.attr("name") == "parent_id") {
                            //remove the same rile from parent
                            ele.find("[value='" + $json['id'] + "']").remove()
                        }

                        if (ele.attr("name") == "status") {

                            ele.each(function() {
                                let ele1 = $(this)
                                ele1.removeAttr("checked")
                                if (ele1.attr("value") == $json['status']) {
                                    console.log(ele1, $json['status'])
                                    ele1.click()
                                }
                            })

                        } else {
                            ele.val($json[$field])
                        }

                    }


                }
                myModal.show()
            })
        </script>
    @endsection




    @section('js')
    @endsection
