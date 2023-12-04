@extends('layouts.superadmin_app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @php
              $title= "All ".(isset($_GET['status']) ? $_GET['status'] : '')." Tasks";
            @endphp
            <x-card :title="$title" classes="border border-info">

                <x-display-errors />

                <x-display-form-errors />

                <div class="row">

                    <div class="col-md-3">
                        <form class="needs-validation" novalidate="" method="post">

                            <x-card title="Tasks expiring Today" classes="border border-info"    >
                                <x-fancy-table>
                                    <x-fancy-table-body>
                                        @foreach($expiringToday as $task)
                                        <tr >
                                            <td class="">
                                                <div class="widget-content px-3 py-2 bg-warning">
                                                    <div class="widget-content-wrapper "> 
                                                        <div class="widget-content-left flex2">
                                                            <div class="widget-heading"> 
                                                                <a href="{{route('tasks.edit', $task->id)}}">
                                                                    {{$task->task_name}}
                                                                </a>
                                                            </div>
                                                            <div class="widget-subheading opacity-7" style="font-size: 14px">
                                                                <span>
                                                                    <i class="fa fa-user"></i> <b> {{$task->taskLead->name}} </b>
                                                                </span>
                                                            |
                                                                <span>
                                                                    <i class="fa fa-newspaper"></i> <b> {{$task->project->project_name}} </b>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </x-fancy-table-body>
                                </x-fancy-table>

                                <div class="container mt-3">{{$expiringToday->appends(request()->except('paginateTaskList'))->links()}}</div>
                            </x-card>
                        </form>
                    </div>
                    <div class="table-responsive col-md-9">

                        <x-fancy-table>
                            <x-fancy-table-head>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Task Title</th>
                                    <th>Task Description</th>
                                    <th class="text-center">Project</th>
                                    <th class="text-center">Priority</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </x-fancy-table-head>

                            <x-fancy-table-body>

                                @php
                                 $i=1;   
                                @endphp
                                @foreach ($tasks as $task)
                                    
                                
                                <tr>
                                    <td class="text-center text-muted">{{$i}}</td>
                                    <td>
                                        <div class="widget-content p-0">
                                            <div class="widget-content-wrapper"> 
                                                <div class="widget-content-left flex2">
                                                    <div class="widget-heading"> 
                                                        <a href="{{route('tasks.edit', $task->id)}}">
                                                            {{$task->task_name}}
                                                        </a>
                                                    </div>
                                                    <div class="widget-subheading opacity-7" style="font-size: 12px">
                                                        <i class="fa fa-user"></i> <b> {{$task->taskLead->name}} </b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
 

                                    <td class="">
                                        <div  >{{$task->task_description}}</div>
                                    </td>

                                    <td class="text-center">
                                        <div class="badge badge-info">{{$task->project->project_name}}</div>
                                    </td>
 
                                    <td class="text-center">
                                        <div class="badge badge-success">{{$task->priority}}</div>
                                    </td>

                                    <td class="text-center" style="min-width: 150px">
                                        <a href="{{route('tasks.show', ['task'=>$task->id])}}" type="button" class="btn btn-info btn-sm">
                                            View
                                        </a>
                                        <a href="{{route('tasks.edit', ['task'=>$task->id])}}" type="button" class="btn btn-primary btn-sm">
                                            Edit
                                        </a>

                                        @if($_GET['status']=="under-review")

                                        <form class="d-inline-block" action="{{route('tasks.submit')}}" method="post">
                                        @csrf
                                        <input type="text" hidden name="task_id" value="{{$task->id}}">
                                        <input value="complete" hidden name="status">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            Mark Complete
                                        </button>
                                        </form>
                                        
                                        @endif
                                    </td>
                                </tr>
                                @php
                                $i++;   
                               @endphp
                                @endforeach
                

                              
                            </x-fancy-table-body>
                        </x-fancy-table>
                        
                        <div class="mt-3 container">{{$tasks->appends(request()->except('paginateExpiringTasks'))->links()}}</div>
                    </div>


                </div>
            </x-card>
        </div>
    </div>



@endsection

@section("js")
<x-hide-sidebar-on-load></x-hide-sidebar-on-load>
@endsection