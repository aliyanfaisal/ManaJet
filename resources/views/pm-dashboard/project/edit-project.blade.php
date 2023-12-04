@extends('layouts.superadmin_app', ['use_bootstrap_js' => true])

@section('content')


    @if (!Auth::user()->userCan('can_add_project') && !Auth::user()->isTeamLead($project->team_id))
        <style>
            input,
            select,
            textarea {
                pointer-events: none;

            }
        </style>
    @endif

    <div class="container-fluid w-8">

        <x-resource-delete-btn :id="$project->id" idx="project_del_{{ $project->id }}" resource="project"
            resourceSingle="project" />


        <div>
            @php
                $tabb = '';
                if (Auth::user()->userCan('can_add_project')  ) {
                    $tabb = ' <span>
                                                <button onclick="deleteResource(\'project_del_'.$project->id.'\')"
                                                    type="button" class="btn btn-danger btn-sm">
                                                    Delete Project
                                                </button>
                                            </span>';
                }

            @endphp
            <x-card title="<h4><b>{{ $project->project_name }}</b></h4>" :tab1="$tabb" classes="border border-info">

                <div class=" px-md-5">

                    <x-display-errors />

                    <x-display-form-errors />
                    <form enctype="multipart/form-data" autocomplete="off" class="needs-validation row" novalidate=""
                        method="post" action="{{ route('project.update', ['project' => $project->id]) }}">
                        @csrf

                        @method('PUT')
                        <div class="col-md-4 order-md-2 mb-4">

                            <x-card title="Project Preview" classes="border border-info">
                                <div class="text-center">
                                    <img style="max-width: 400px" id="project_image_preview" class="m-auto"
                                        src="{{ $project->projectImageUrl() }}" alt="">
                                    <b class="badge badge-info position-absolute"
                                        style="left: 7px; top: 70px;  font-size: 20px;"> <span
                                            id="budget_preview">{{ $project->budget }}</span>
                                        {{ env('CURRENCY_SYMBOL', 'PKR') }}</b>
                                    <h5 class="font-weight-bold my-3" id="project_name_preview"
                                        style="text-transform: capitalize">{{ $project->project_name }}</h5>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span><b class="badge badge-info fsize-1"
                                                id="project_category_preview">{{ $project->category->cat_name }}</b></span>
                                        <span><b class="badge badge-warning fsize-1"
                                                id="team_id_preview">{{ $project->team->team_name }}</b></span>
                                    </div>
                                </div>
                            </x-card>


                            <h5 class="mb-3">Project Status</h5>

                            <div class="d-block my-3">
                                <div class="custom-control custom-radio">
                                    <input id="project_condition" name="project_condition" type="radio"
                                        class="custom-control-input" @checked($project->condition == 'publish') value="publish"
                                        checked="" required="">
                                    <label class="custom-control-label" for="project_condition">Publish</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input id="project_condition" name="project_condition" type="radio"
                                        class="custom-control-input" @checked($project->condition == 'draft') required=""
                                        value="draft">
                                    <label class="custom-control-label" for="project_condition">Draft</label>
                                </div>
                            </div>
                            <hr class="mb-4">

                            @if (Auth::user()->userCan('can_add_project') || Auth::user()->isTeamLead($project->team_id))
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Update Project</button>
                            @endif

                        </div>
                        <div class="col-md-8 order-md-1">
                            <div>
                                <h5 class="mb-1">Project Progress</h5>
                                <x-progress-card value="{{ $project->progress()['progress_percentage'] }}"
                                    color="{{ $project->progress()['status_color'] }}" showCard="false" />
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="project_name">Project Name</label>
                                        <input type="text" class="form-control" name="project_name" id="project_name"
                                            placeholder="Project Title" value="{{ $project->project_name }}"
                                            required="">
                                        <div class="invalid-feedback">
                                            Project name is required.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">

                                        <label for="project_category">Project Category</label>
                                        <select class="custom-select d-block w-100" name="project_category"
                                            id="project_category" required="">
                                            <option value="">Choose...</option>
                                            @foreach ($p_cats as $cat)
                                                <option @selected($project->project_category == $cat->id) value="{{ $cat->id }}">
                                                    {{ $cat->cat_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a Category.
                                        </div>


                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-6 mb-3">

                                        <label for="budget">Project budget</label>
                                        <input type="number" name="budget" class="form-control" id="budget"
                                            placeholder="" value="{{ intval($project->budget) }}" required="">
                                        <div class="invalid-feedback">
                                            Budget field is required.
                                        </div>
                                    </div>

                                    @if (!$project->hasTasks())
                                        <div class="col-md-6 mb-3">
                                            <label for="team_id">Team</label>
                                            <select name="team_id" class="custom-select d-block w-100" id="team_id"
                                                required="">
                                                <option value="">Choose...</option>
                                                @foreach ($teams as $team)
                                                    <option @selected($project->team_id == $team->id) value="{{ $team->id }}">
                                                        {{ $team->team_name }}</option>
                                                @endforeach
                                            </select>
                                            <div class="invalid-feedback">
                                                Team is required.
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="row">
                                    <div class="col-12  mb-3">
                                        <label for="project_image">Project Image</label>
                                        <input type="file" class=" form-control-file " name="project_image"
                                            id="project_image">

                                        <div class="invalid-feedback">
                                            Invalid Image.
                                        </div>

                                    </div>
                                </div>
                                <hr>
                                <div class="mb-3">
                                    <label for="project_description">Project Description</label>
                                    <textarea rows="7" class="form-control" name="project_description" id="project_description"
                                        placeholder="Summary of the project" required="">{{ $project->project_description }}</textarea>
                                    <div class="invalid-feedback">
                                        Invalid description.
                                    </div>
                                </div>


                            </div>
                        </div>
                    </form>


                    <hr>
                </div>

            </x-card>

        </div>
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





    <div class="container-fluid w-8">
        <div>
            @php
                $tabb = '';
                if (Auth::user()->userCan('can_add_notice') || Auth::user()->isTeamLead($project->team_id)) {
                    $tabb = "<button id='add_noticex' class='btn btn-primary text-white'>Add Notice</button>";
                }
            @endphp
            <x-card title="<h4><b>Notice Board</b></h4>" :tab1="$tabb" classes="border border-info">


                <div class="table-responsive">

                    <x-fancy-table>
                        <x-fancy-table-head>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Notice Name</th>
                                <th class="text-center">Description</th>  
                                <th class="text-center">Actions</th>
                            </tr>
                        </x-fancy-table-head>

                        <x-fancy-table-body>

                            @php
                                $i = 1;
                            @endphp
                            @foreach ($notices as $notice)
                                <tr>
                                    <td class="text-center">{{ $i }}</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading"><a
                                                            href="{{ route('notices.edit', $notice->id) }}">{{ $notice->notice_title }}</a>
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">{{ $notice->notice_content}}</td> 

                                    <td class="text-center">
                                        <a href="{{ route('notices.edit', $notice->id) }}" type="button"
                                            class="btn btn-primary btn-sm">
                                            View/Edit
                                        </a>

                                        <x-resource-delete-btn :id="$notice->id"
                                                    idx="notice_del_{{ $notice->id }}" resource="notices"
                                                    resourceSingle="notice" />


                                                <button onclick="deleteResource('notice_del_{{ $notice->id }}')"
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
                        {{ $notices->links() }}
                    </div>
                </div>

            </x-card>
        </div>
    </div>


  <div class="modal" tabindex="-1" id="edit_form_modal" data-bs-backdrop="false"  style="top: 60px">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="role_title_modal">Add a New Notice</h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" class="needs-validation" novalidate="" method="post"
                        action="{{ route('notices.store') }}" id="main_form">
                        @csrf
                        <input type="text"  name="project_id" value="{{$project->id}}" hidden>
                        <x-card title="New Notice" classes="border border-info">
                            <div class="">

                                <div>
                                    <div class="">
                                        <div class=" mb-3">
                                            <label for="notice_title">Notice Title</label>
                                            <input type="text" class="form-control" name="notice_title" id="notice_title"
                                                placeholder="Notice Title" value="{{ old('notice_title') }}" required="">
                                            <div class="invalid-feedback">
                                                Notice Title is required.
                                            </div>
                                        </div> 
                                    </div>

                                    <div>
                                        <label for="notice_content">Notice Content</label>
                                        <textarea class="form-control mb-3" placeholder="Notice Content" name="notice_content" id="notice_content" rows="5">{{ old('notice_content') }}</textarea>
                                    </div>
 
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Add Notice</button>


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
        $(document).on("keyup", "input,select", function() {
            console.log("chnaging")
            changePreview($(this))
        })

        $(document).on("change", "input,select", function() {

            changePreview($(this))
        })


        function changePreview($this) {

            if ($this.attr("type") == "file") {

                changeProfileImage($this)
                return false
            }

            const $id = $this.attr("id")

            var value = $this.val();

            if ($id.includes("project_category") || $id.includes("team")) {
                value = $("#" + $id + " option[value='" + value + "']").html()

            } else {

            }

            console.log("va;", value, $id)

            $("#" + $id + "_preview").html(value)

        }


        function changeProfileImage($this) {

            console.log("files", $this[0])
            var reader = new FileReader();

            reader.onload = function(e) {

                $("#" + $this.attr("id") + "_preview").attr("src", e.target.result)
            };

            reader.readAsDataURL($this[0].files[0]);

        }
    </script>
 
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('edit_form_modal'), {
            keyboard: false
        })

        $("#add_noticex").on("click", function() {

            myModal.show()

        }) 
    </script>
@endsection