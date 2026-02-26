@extends('layouts.superadmin_app')

@section('content')
    <div class="container-fluid w-8" id="form_top">
        <div>
            <x-card
                title="Add Tasks To &nbsp;<span class='text-primary fsize-2'>{{ Str::upper($project->project_name) }}</span>"
                tab1="<a href='{{ route('project.edit', ['project' => $project->id]) }}' class='btn btn-primary '>Go To Project</a>"
                classes="border border-info">

                <div class="container-fluid px-md-5">

                    <x-display-errors />

                    <x-display-form-errors />
                    <form enctype="multipart/form-data" autocomplete="off" class="needs-validation row" novalidate=""
                        method="post" action="{{ route('tasks.store') }}">
                        @csrf
                        <input type="text" hidden name="project_id" value="{{ $project->id }}">
                        <div class="col-md-12 order-md-1">
                            <div>
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="task_name">Task Name</label>
                                        <input type="text" class="form-control" name="task_name" id="task_name"
                                            placeholder="Task Title" value="{{ old('task_name') }}" required="">
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
                                                <option @selected(old('task_lead_id') == $mem->id) value="{{ $mem->id }}">
                                                    {{ $mem->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a Task Lead.
                                        </div>
                                    </div>

                                    <div class="col-md-3 mb-3">

                                        <label for="task_deadline">Task Deadline</label>
                                        <input type="date" value="{{ old('task_deadline') }}" class="form-control"
                                            name="task_deadline" id="task_deadline" required>
                                        <div class="invalid-feedback">
                                            Please select a Deadline.
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-3">

                                        <label for="priority">Task Priority</label>
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
                                        <label for="task_description">Task Description</label>
                                        <textarea rows="7" class="form-control" name="task_description" id="task_description"
                                            placeholder="Summary of the Task" required="">{{ old('task_description') }}</textarea>
                                        <div class="invalid-feedback">
                                            Invalid description.
                                        </div>
                                    </div>

                                    <div class="col-md-2 mb-3">

                                        <label for="task_step_no">Step No. <span
                                                class="text-muted">(optional)</span></label>
                                        <input type="number" placeholder="Step Number" class="form-control"
                                            name="task_step_no" id="task_step_no">

                                        <div class="invalid-feedback">
                                            Please select a Deadline.
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Add Task</button>

                                </div>


                                <hr>
                                <div class="text-center font-weight-bold">OR</div>
                                <hr>
                                <x-fancy-table>
                                    <x-fancy-table-head>
                                        <tr>
                                            <th class="text-center">Auto Generate Using ChatGPT</th>
                                            <th class="text-center">

                                                @php
                                                $enable_chatgpt= App\Models\Option::where("option_key","enable_chatgpt")->first();
                                                @endphp

                                                @if( $enable_chatgpt!=null && $enable_chatgpt->option_value != "" )
                                                <button class="btn btn-danger text-light btn-lg btn-block "
                                                    id="auto_generate_tasks" type="button">Auto Generate Tasks</button>
                                                @else
                                                    <h5 class="font-weight-bold text-danger">ChatGPT Not Enabled</h5>
                                                @endif
                                            </th>
                                        </tr>
                                    </x-fancy-table-head>
                                </x-fancy-table>

                            </div>
                        </div>
                    </form>

                </div>

            </x-card>


        </div>
    </div>




    @php
        $generated_tasks = json_decode(htmlspecialchars_decode($generated_tasks));
    @endphp

    <div id="shows_tasks" class="container-fluid w-8 @if ($generated_tasks==null) d-none @endif">

        <x-card title="<h4>Generated Tasks</h4>" classes="border border-info">


            <div class="table-responsive">
                <x-fancy-table>
                    <x-fancy-table-head>
                        <tr>
                            <th class="">Step#</th>
                            <th>Task Name</th>
                            <th class="">Description</th>
                            <th class='text-center'>Priority</th>
                            <th class='text-center'>Days Needed</th>
                            <th class="">Actions</th>
                        </tr>
                    </x-fancy-table-head>

                    <x-fancy-table-body>
                        @php
                            $i = 0;

                            if($generated_tasks == null){
                                $generated_tasks=[];
                            }
                        @endphp
                        @foreach ($generated_tasks as $task)
                        @php
                        $i++;
                        @endphp
                        <?php 
                        if($project->hasTask($task->task_name)){
                            continue;
                        }
                        ?>
                            <tr>
                                <td class='text-center'>{{ $i }}</td>
                                <td><b>{{ $task->task_name }}</b></td>
                                <td style="max-width:500px">{{ $task->task_description }}</td>
                                <td class='text-center'>{{ $task->priority }} </td>
                                <td class='text-center'>{{ $task->days_needed }}</td>
                                <td> <button class='btn btn-primary add_gen_task' data-json='{{ json_encode($task) }}'>Edit
                                        and Add</button> </td>
                            </tr>

                           
                        @endforeach
                    </x-fancy-table-body>

                </x-fancy-table>

            </div>
        </x-card>
    </div>




    <div class="container-fluid w-8">
        <div>
            @php
                $tabb = '';
                if (Auth::user()->userCan('can_add_task') || Auth::user()->isTeamLead($project->team_id)) {
                    $tabb = "<a href='" . route('tasks.create') . "?project_id=$project->id' class='btn btn-primary'>Add Tasks</a>";
                }
            @endphp
            <x-card title="<h4><b>Project Tasks</b></h4>" :tab1="$tabb" classes="border border-info">


                <div class="table-responsive">

                    <x-fancy-table>
                        <x-fancy-table-head>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Task Name</th>
                                {{-- <th class="text-center">Description</th> --}}
                                <th class="text-center">Priority</th>
                                <th class="text-center">Lead</th>
                                <th class="text-center">Days Left</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
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
                                                    <div class="widget-subheading opacity-7">
                                                        <b>{{ Str::limit($task->task_description, 20) }}</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    {{-- <td class="text-center">{{ $task}}</td> --}}

                                    <td class="text-center">
                                        <div class="badge badge-info">{{ $task->priority }}</div>
                                    </td>

                                    <td class="text-center">{{ $task->taskLead->name }}</td>

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

                                    <td class="text-center">
                                        <a href="{{ route('tasks.edit', $task->id) }}" type="button"
                                            class="btn btn-primary btn-sm">
                                            View/Edit
                                        </a>

                                        <x-resource-delete-btn :id="$task->id"
                                            idx="task_del_{{ $task->id }}" resource="tasks"
                                            resourceSingle="task" />


                                        <button onclick="deleteResource('task_del_{{ $task->id }}')"
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
                        {{ $tasks->links() }}
                    </div>
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
        $(document).on("click", "#auto_generate_tasks", function() {
            $hints = prompt("Add some hints for Generating Tasks. e.g (wordpress,website,portfolio,elementor)")

            $("#preloader").css("display", "flex")
            var $project_data = {
                "id": "{{ $project->id }}",
                "project_name": "{{ $project->project_name }}",
                "project_category": "{{ $project->category->cat_name }}",
                "project_description": "{{ $project->project_description }}"
            }


            $.post({
                "url": "{{ route('get-tasks-gpt') }}",
                "headers": {
                    "Authorization": "Bearer {{ Session::get('user_token') }}"
                },
                "data": {
                    "_token": "{{ csrf_token() }}",
                    "project": $project_data,
                    "hints": $hints
                },
                "success": function(data) {

                    const hasSquareBrackets = data.includes('[') && data.includes(']');

                    let $tasks = "";

                    if (hasSquareBrackets) {
                        // Square brackets are present, the response is already in array format
                        $tasks = JSON.parse(data);
                    } else {
                        // Square brackets are not present, add them and then parse as an array
                        const jsonArrayText = `[${data}]`;
                        $tasks = JSON.parse(jsonArrayText);
                    }

                    console.log($tasks)

                    addTasksToTable($tasks)

                    $("#preloader").css("display", "none")


                },
                "error": function(err) {
                    alert("Error While Generating Tasks")
                }
            })
            console.log("data", $project_data)

        })


        function addTaskToEdit(button) {
            let jsonData = button.data("json")

            for (let field in jsonData) {

                $("#" + field).val(jsonData[field])

                if (field == "days_needed") {
                    var currentDate = new Date();

                    var futureDate = new Date();
                    futureDate.setDate(currentDate.getDate() + parseInt(jsonData[field]));
                    console.log(futureDate)
                    var year = futureDate.getFullYear();
                    var month = futureDate.getMonth() + 1;
                    var day = futureDate.getDate();

                    var formattedDate = year + '-' + (month < 10 ? '0' : '') + month + '-' + (day < 10 ? '0' : '') + day;

                    document.getElementById('task_deadline').value = formattedDate;

                    $('html, body').animate({
                        scrollTop: $("#form_top").offset().top
                    }, 1000);
                } else if (field == "priority") {
                    $("#" + field).val(jsonData[field].toLowerCase())
                }
            }
        }




        function addTasksToTable($tasks) {
            let i = 1;
            let $tasks_html = ""
            for ($task in $tasks) {
                let task_json = JSON.stringify($tasks[$task])
                $tasks_html += `<tr> 
                            <td>${i} </td>
                            <td><b>${$tasks[$task].task_name}</b></td>  
                            <td>${$tasks[$task].task_description} </td>
                            <td class='text-center'>${$tasks[$task].priority} </td>
                            <td class='text-center'>${$tasks[$task].days_needed} </td>
                            <td> <button class='btn btn-primary add_gen_task' data-json='${task_json}'>Edit and Add</button> </td>
                        </tr>`

                i++
            }

            $("#shows_tasks table tbody").html()
            $("#shows_tasks table tbody").html($tasks_html)
            $("#shows_tasks").removeClass("d-none")
        }




        $(document).on( "click",".add_gen_task", function() {
            addTaskToEdit($(this))
        })
    </script>
@endsection
