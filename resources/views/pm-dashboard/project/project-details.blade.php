@extends('layouts.guest_app',  ['use_bootstrap_js' => true])

@section('content')


    <div class="container-fluid w-8">

        <x-resource-delete-btn :id="$project->id" idx="project_del_{{ $project->id }}" resource="project"
            resourceSingle="project" />


        <div>


            <x-card title="<h4><b>{{ $project->project_name }}</b></h4>"   classes="border border-info">
                	<x-display-errors />

                    <x-display-form-errors />

                <div class="row px-4">
                    <div class="col-md-4 mb-3 border border-info">


  								<div class="container-fluid w-8">
				                    <hr>
					                <h5 class="mb-1">Project Progress</h5>
					                <x-progress-card value="{{ $project->progress()['progress_percentage'] }}"
					                    color="{{ $project->progress()['status_color'] }}" showCard="false" />
					                <hr>
				                </div>


                        <div class="text-center">
                            <div class="">
                                <img class="img-responsive img-fluid" style="max-width: 300px" src="{{ $project->projectImageUrl() }}"
                                    alt="">
                            </div>

                            <div class="mt-3">
                                <h5 class="font-weight-bold fsize-3">{{ $project->project_name }}</h5 class="font-weight-bold">
                                <p>
                                    {{ $project->project_description }}
                                </p>
                            </div>
                        </div>
                        <x-fancy-table classes="text-center">
                            <x-fancy-table-body>


                                <tr>
                                    <th>Lead</th>
                                    <th>
                                        <div class="badge badge-warning">{{ $project->team->teamLead->name }}</div>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <th>
                                        <div class="badge badge-info">{{ $project->category->cat_name }}</div>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Budget</th>
                                    <th>
                                        <div class="badge badge-info">{{ $project->budget }}
                                            {{ env('DEFAULT_CURRENCY', 'PKR') }}</div>
                                    </th>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <th>
                                        <div class="badge badge-info">{{ $project->project_status }}</div>
                                    </th>
                                </tr>
                            </x-fancy-table-body>

                        </x-fancy-table>
                      


                    </div>

                    <div class="col-md-8 mb-3 border ">

                        <div>
                            <x-card title="<h4><b>Project Ticket</b></h4>" tab1="<a href='{{route('tickets.create', ['project_id'=>$project->id])}}' class='btn btn-primary'>Add Tickets</a>" classes="border border-info">


                                <div class="table-responsive">

                                    <x-fancy-table>
                                        <x-fancy-table-head>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Ticket Name</th>
                                                {{-- <th class="text-center">Description</th> --}}
                                                <th class="text-center">Priority</th>
                                                <th class="text-center">Reference Task</th>
                                                <th class="text-center">Deadline</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </x-fancy-table-head>

                                        <x-fancy-table-body>

                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($tickets as $ticket)
                                                <tr>
                                                    <td class="text-center">{{ $i }}</td>
                                                    <td>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left flex2">
                                                                    <div class="widget-heading"><a
                                                                            href="{{ route('tickets.edit', $ticket->id) }}">{{ $ticket->ticket_name }}</a>
                                                                    </div>
                                                                    <div class="widget-subheading opacity-7">
                                                                        <b>{{ Str::limit($ticket->ticket_description, 20) }}</b>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>

                                                    {{-- <td class="text-center">{{ $ticket}}</td> --}}

                                                    <td class="text-center">
                                                        <div class="badge badge-info">{{ $ticket->priority }}</div>
                                                    </td>

                                                    <td class="text-center">{{ $ticket->task ? $ticket->task->task_name : "" }}</td>

                                                    @php
                                                        $now = new DateTime();
                                                        $then = new DateTime($ticket->ticket_deadline);

                                                        $interval = $then->diff($now);

                                                    @endphp
                                                    <td class="text-center text-underline">
                                                        <div class="badge badge-secondary">{{ $interval->days }} Day(s)
                                                        </div>
                                                    </td>

                                                    <td class="text-center">
                                                        <div
                                                            class="badge badge-@if ($ticket->status == 'complete'){{ 'success' }} @else{{ 'warning' }} @endif">
                                                            {{ $ticket->status }}</div>
                                                    </td>

                                                    <td class="text-center">
                                                        
                                                        <a href="{{route('tickets.show',['ticket'=>$ticket->id])}}" type="submit" class="btn btn-info btn-sm">
                                                                View
                                                            </a>

                                                        <x-resource-delete-btn :id="$ticket->id"
		                                                    idx="project_ticket_del_{{ $ticket->id }}" resource="tickets"
		                                                    resourceSingle="ticket" />


		                                                <button onclick="deleteResource('project_ticket_del_{{ $ticket->id }}')"
		                                                    type="button" class="btn btn-danger btn-sm">
		                                                    Delete 
		                                                </button>

                                                    </td>
                                                </tr>

                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        </x-fancy-table-body>
                                    </x-fancy-table>

                                    <div>
                                        {{ $tickets->links() }}
                                    </div>
                                </div>

                            </x-card>
                        </div>

                    </div>
                </div>

   

                <div>

                    <div class="container-fluid w-8">
                        <div>
                           
                            <x-card title="<h4><b>Project Tasks</b></h4>"  classes="border border-info">
                
                
                                <div class="table-responsive">
                
                                    <x-fancy-table>
                                        <x-fancy-table-head>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Task Name</th>
                                                <th>Description</th>
                                                <th class="text-center">Priority</th>
                                                <th class="text-center">Lead</th>
                                                <th class="text-center">Days Left</th>
                                                <th class="text-center">Status</th>
                                            </tr>
                                        </x-fancy-table-head>
                
                                        <x-fancy-table-body>
                
                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($tasks as $task)
                                                <tr>
                                                    <td class="text-center">{{ $i }}</td>
                                                    <td>
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left flex2">
                                                                    <div class="widget-heading"><a
                                                                            href="{{ route('tasks.edit', $task->id) }}">{{ $task->task_name }}</a>
                                                                    </div>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                
                                                    <td>
                                                    	<div class="widget-subheading opacity-7">
                                                            <b>{{ $task->task_description }}</b>
                                                        </div>
                                                    </td> 
                
                                                    <td class="text-center">
                                                        <div class="badge badge-info">{{ $task->priority }}</div>
                                                    </td>
                
                                                    <td class="text-center">
                                                    	<div class="badge badge-warning ">{{ $task->taskLead->name }}</div>
                                                    </td>
                
                                                    @php
                                                        $now = new DateTime();
                                                        $then = new DateTime($task->task_deadline);
                
                                                        $interval = $then->diff($now);
                
                                                    @endphp
                                                    <td class="text-center text-underline">
                                                        <div class="badge badge-secondary">{{ $interval->days }} Day(s)</div>
                                                    </td>
                
                                                    <td class="text-center">
                                                        <div
                                                            class="badge badge-@if ($task->status == 'complete'){{ 'success' }} @else{{ 'warning' }} @endif">
                                                            {{ $task->status }}</div>
                                                    </td>
                
                                                    
                                                </tr>
                
                                                @php
                                                    $i++;
                                                @endphp
                                            @endforeach
                                        </x-fancy-table-body>
                                    </x-fancy-table>
                
                                    <div>
                                        {{ $tasks->links() }}
                                    </div>
                                </div>
                
                            </x-card>
                        </div>
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
                                            <input readonly type="text" class="form-control" name="ticket_name" id="ticket_name"
                                                placeholder="Category Name">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="cat_name">Description</label>
                                            <input readonly type="text" class="form-control" name="ticket_description" id="ticket_description"
                                                placeholder="Category Name">
                                        </div>
                                        
                                    </div>


                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cat_name">Ticket Name</label>
                                            <input readonly type="text" class="form-control" name="ticket_name" id="ticket_name"
                                                placeholder="Category Name">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="priority">Priority</label>
                                            <input readonly type="text" class="form-control" name="priority" id="priority"
                                                placeholder="Category Name">
                                        </div>
                                        
                                    </div>



                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cat_name">Reference Task</label>
                                            <input readonly type="text" class="form-control" name="reference_task_id" id="reference_task_id"
                                                placeholder="Category Name">
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="status">Status</label>
                                            <input readonly type="text" class="form-control" name="status" id="status"
                                                placeholder="Category Name">
                                        </div>
                                        
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="">Deadline</label>
                                            <input readonly type="text" class="form-control" name="task_deadline" id="task_deadline"
                                                placeholder="Category Name">
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
