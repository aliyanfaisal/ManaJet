@extends('layouts.guest_app')

@section('content')
    <div class="container-fluid w-8">




        <div>

            <x-card title="<h4><b>{{ $ticket->ticket_name }}</b></h4>"
            tab1="<a href='{{ route('project.client', ['project' => $ticket->project->id]) }}' class='btn btn-primary '>Go To Project</a>"
            classes="border border-info">

                <div class="row px-4">
                    <div class="col-md-4 mb-3 border border-info"
                        style="display: flex;
                    flex-direction: column;
                    justify-content: center;">

                       
                        <x-fancy-table classes="text-center">
                            <x-fancy-table-body>
                                <tr>
                                    <th>Priority</th>
                                    <th>
                                        <div class="badge fsize-1 badge-secondary">{{ $ticket->priority }}</div>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Lead</th>
                                    <th>
                                        <div class="badge fsize-1 badge-warning">{{ ($ticket->ticketLead) ?? "" }}</div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Project</th>
                                    <th>
                                        <div class="badge fsize-1 badge-primary"> {{ $ticket->project->project_name }} </div>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Days Left</th>
                                    <th>
                                        @php
                                            $now = new DateTime();
                                            $then = new DateTime($ticket->ticket_deadline);

                                            $interval = $then->diff($now);

                                        @endphp
                                        <div class="badge fsize-1 badge-info">{{ $interval->days }} Day(s)</div>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <th>
                                        <div class="badge fsize-1 badge-danger">{{ $ticket->status }}</div>
                                    </th>
                                </tr>
 
                            </x-fancy-table-body>

                        </x-fancy-table>

                    </div>

                    <div class="col-md-8 mb-3 border ">
                        <x-card title="Ticket Description"  classes="border border-info">
                             
                               <p>{{$ticket->ticket_description}}</p>
                            
                        </x-card>


                        <x-card title="Attachments"  classes="border border-info">
                             
                               @php
                                $attachments= $ticket->attachments();
                               @endphp
                            
                            @foreach($attachments as $attach)

                            <a href='{{Storage::url("$attach->file_path")}}' download="">
                                <img class="img-fluid" style="max-width:300px"  src="{{Storage::url("$attach->file_path")}}">
                            </a>
                            @endforeach
                        </x-card>
                    </div>
                </div>


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
                                            <label for="cat_name">Reference ticket</label>
                                            <input readonly type="text" class="form-control" name="reference_ticket_id"
                                                id="reference_ticket_id" placeholder="Category Name">
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
                                            <input readonly type="text" class="form-control" name="ticket_deadline"
                                                id="ticket_deadline" placeholder="Category Name">
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
