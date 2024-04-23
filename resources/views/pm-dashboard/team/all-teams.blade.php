@extends('layouts.superadmin_app')

@section('content')

<style>
    .badge{
        font-size: 100%
    }
</style>
    <div class="row">
        <div class="col-md-12">
            @php
                $title = 'All Teams';
            @endphp
            <?php 
            $tabb="";
                if(Auth::user()->userCan('can_add_project')){  
                    $tabb="<a href='".route('teams.create')."' class='btn btn-primary '>Add a Team</a>"; 
                } 
            ?>
            <x-card :title="$title" :tab1="$tabb" classes="border border-info">
                <div class="row">

                    @foreach ($teams as $team )
                    <div class="col-md-4">
                        <x-card title='<a href="{{route("teams.edit",["team"=>$team->id])}}" class=" fsize-2 " style="text-decoration:underline;font-weight:700">{{$team->team_name}}</a>' 
                            tab1='<b class="badge badge-danger" id="preview_cat">{{$team->category->cat_name}}</b>'
                            classes="border border-info">

                            <x-fancy-table>
                                <x-fancy-table-head>
                                    <tr>
                                        <th class="text-center">Team Lead</th>
                                        <th class="text-center">Projects Completed</th>
                                    </tr>
                                </x-fancy-table-head>
    
                                <x-fancy-table-body>
                                    <tr>
                                        <td class="text-center">
                                            <div class="badge badge-info " style="font-size:100%">{{$team->teamLead->name}}</div>
                                        </td>
     
                                        <td class="text-center">
                                            <div class="badge badge-success">{{$team->completedProjects()}}</div>
                                        </td>

                                    </tr>
                                </x-fancy-table-body>
                            </x-fancy-table>
                            <p class="mt-3 text-center" style="line-height: 24px"> 
                                {{$team->team_description}}
                            </p>
                            
                        </x-card>
                    </div>                 
                    @endforeach
 

                </div>

                <div class="mt-3">
                    {{$teams->links()}}
                    
                </div>
            </x-card>
        </div>
    </div>
@endsection


@section('js')
    <x-hide-sidebar-on-load></x-hide-sidebar-on-load>
@endsection
