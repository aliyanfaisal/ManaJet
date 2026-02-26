@extends('layouts.superadmin_app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @php
              $title= "Recent Tickets";
            @endphp
            <x-card :title="$title" classes="border border-info">
                <div class="row">

                    <div class="col-md-6">
                            <x-card title="All Un-Solved Tickets" classes="border border-info">
                                <div class="table-responsive ">

                                    <x-fancy-table>
                                        <x-fancy-table-head>
                                            <tr>
                                                <th>Ticket Title</th>
                                                <th class="text-center">Project Name</th>
                                                <th class="text-center">Prioriry</th>
                                                <th class="text-center">Actions</th>
                                            </tr>
                                        </x-fancy-table-head>
            
                                        <x-fancy-table-body>

                                            @php
                                                $i = 1;
                                            @endphp
                                            @foreach ($pending_tickets as $ticket)
                                                <tr> 
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

                                                    <td class="text-center">{{ $ticket->project ? $ticket->project->project_name : "" }}</td>

                                                    <td class="text-center">
                                                        <div class="badge badge-info">{{ $ticket->priority }}</div>
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
                                </div>
                            </x-card>
                    </div>

                    <div class="col-md-6">
                        <x-card title="All Solved Tickets" classes="border border-info">
                            <div class="table-responsive ">

                              
                                <x-fancy-table>
                                    <x-fancy-table-head>
                                        <tr>
                                            <th>Name</th>
                                            <th class="text-center">Project Name</th>
                                            <th class="text-center">Prioriry</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </x-fancy-table-head>
        
                                    <x-fancy-table-body>

                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($completed_tickets as $ticket)
                                            <tr> 
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

                                                <td class="text-center">{{ $ticket->project ? $ticket->project->project_name : "" }}</td>

                                                <td class="text-center">
                                                    <div class="badge badge-info">{{ $ticket->priority }}</div>
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
                            </div>
                        </x-card>
                </div>


                </div>
            </x-card>
        </div>
    </div>

@endsection


@section("js")
<x-hide-sidebar-on-load></x-hide-sidebar-on-load>
@endsection