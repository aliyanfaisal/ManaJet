@extends('layouts.superadmin_app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <?php
            $tabb = '';
            if (Auth::user()->userCan('can_add_project')) {
                $tabb = "<a href='" . route('project.create') . "' class='btn btn-primary '>Add a Project</a>";
            }
            ?>
            <x-card title="All Projects" :tab1="$tabb" classes="border border-info">
                <div class="table-responsive">

                    <x-fancy-table>
                        <x-fancy-table-head>
                            <tr>
                                <th class="text-center">#</th>
                                <th>Title</th>
                                <th class="text-center">Team</th>
                                <th class="text-center">Category</th>
                                <th class="text-center">Progress</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </x-fancy-table-head>

                        <x-fancy-table-body>
                            @php
                                $i = 1;
                            @endphp


                            @foreach ($projects as $project)
                                <tr class="@if($project->project_status=='completed') border border-success @endif">
                                    <td class="text-center text-muted">#{{ $i }}</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper">
                                                <div class="widget-content-left mr-3">
                                                    <div class="widget-content-left">
                                                        <img width="40" class="rounded-circle"
                                                            src="{{ $project->projectImageUrl() }}" alt="">
                                                    </div>
                                                </div>
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading"><a
                                                            href="{{ route('project.edit', $project->id) }}">{{ $project->project_name }}</a>
                                                    </div>
                                                    <div class="widget-subheading opacity-7">
                                                        <b>{{ Str::limit($project->project_description, 40) }}</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="text-center">{{ $project->team->team_name }}</td>

                                    <td class="text-center">
                                        <div class="badge badge-info">{{ $project->category->cat_name }}</div>
                                    </td>

                                    <td class="text-center">
                                        <x-progress-card value="{{ $project->progress()['progress_percentage'] }}"
                                            color="{{ $project->progress()['status_color'] }}" showCard="false" />
                                    </td>
                                    <td class="text-center">
                                        <div
                                            class="badge badge-@if ($project->project_status == 'completed'){{'success'}} @else{{ 'warning' }} @endif">
                                            {{ $project->project_status }}</div>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('project.board', $project->id) }}" type="button"
                                            class="btn btn-primary btn-sm">
                                            Board
                                        </a>

                                        <a href="{{ route('project.edit', $project->id) }}" type="button"
                                            class="btn btn-info btn-sm">
                                            View/Edit
                                        </a>

                                        @if (Auth::user()->userCan('can_add_project'))
                                            <span>
                                                <x-resource-delete-btn :id="$project->id"
                                                    idx="project_del_{{ $project->id }}" resource="project"
                                                    resourceSingle="project" />


                                                <button onclick="deleteResource('project_del_{{ $project->id }}')"
                                                    type="button" class="btn btn-danger btn-sm">
                                                    Delete
                                                </button>
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach

                        </x-fancy-table-body>
                    </x-fancy-table>

                    <div class="mt-3">
                        {{ $projects->links() }}

                    </div>
                </div>

            </x-card>
        </div>
    </div>
@endsection



@section("js")
<x-hide-sidebar-on-load></x-hide-sidebar-on-load>
@endsection