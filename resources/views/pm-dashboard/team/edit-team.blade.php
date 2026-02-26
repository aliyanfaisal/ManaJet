@php
    $team_members = $team->getMemberIDs();
    
    // print_r ($team_members);
    // exit;
    
@endphp


@extends('layouts.superadmin_app')

@section('content')
    <div class="container-fluid w-8">
        <div>
            <x-card title="Edit a New Team" tab1="<a href='{{route('teams.create')}}' class='btn btn-primary '>Add a Team</a>"  classes="border border-info">

                <div class="container-fluid px-md-5">

                    <x-display-errors />

                    <x-display-form-errors />

                    <div class="needs-validation row" novalidate="">
                        <form autocomplete="false" class="col-md-6 order-md-2" method="post"
                            action="{{ route('teams.updateMembers', ['team' => $team->id]) }}">
                            @csrf
                            <x-card :title="$team->team_name" classes="w-100  border border-info">
                                @if (Request::is('*/teams/create'))
                                    <div class="overlay-disable" style="">
                                        <h5><b>Add a Team first</b>.</h5>
                                    </div>
                                @endif

                                <div>
                                    <h5 class="mb-3">Add Team Members</h5>
                                    <div class="d-flex flex-wrap">
                                        @foreach ($users as $user)
                                            <div class="custom-control custom-checkbox mr-4">
                                                <input @disabled($user->id==$team->team_lead_id) autocomplete="false" class="custom-control-input" type="checkbox"
                                                    name="team_members[]" value="{{ $user->id }}"
                                                    id="user_{{ $user->id }}" @checked(in_array($user->id, $team_members) || $user->id==$team->team_lead_id)>
                                                <label class="custom-control-label " style="font-size: 16px"
                                                    for="user_{{ $user->id }}">
                                                    {{ $user->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <button  class="mt-5 btn btn-primary btn-lg btn-block" type="submit">Update Members</button>

                            </x-card>

                        </form>
                        <form autocomplete="off" novalidate class="col-md-6 order-md-1" method="post"
                            action="{{ route('teams.update', ['team' => $team->id]) }}">
                            @method('patch')
                            @csrf
                            <h4 class="mb-3">Team Details</h4>
                            <div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="team_name">Team Name</label>
                                        <input type="text" class="form-control" value="{{ $team->team_name }}"
                                            name="team_name" id="team_name" placeholder="Team Name" value=""
                                            required="">
                                        <div class="invalid-feedback">
                                            Project name is required.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">

                                        <label for="category_id">Team Category</label>
                                        <select autocomplete="false" class="custom-select d-block w-100" name="category_id"
                                            id="category_id" required="">
                                            <option value="">Choose...</option>
                                            @foreach ($p_cats as $cat)
                                                <option @if ($team->category_id == $cat->id) selected @endif
                                                    value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a Category.
                                        </div>


                                    </div>
                                </div>



                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="team_lead_id">Team Lead</label>
                                        <select autocomplete="false" autof name="team_lead_id"
                                            class="custom-select d-block w-100" id="team_lead_id" required="">
                                            <option value="">Choose...</option>
                                            @foreach ($users as $user)
                                                <option @if ($team->team_lead_id == $user->id) selected @endif
                                                    value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Team is required.
                                        </div>
                                    </div>

                                </div>

                                <div class="mb-3">
                                    <label for="team_description">Team Description</label>
                                    <textarea rows="7" class="form-control" name="team_description" id="team_description"
                                        placeholder="A brief description" required="">{{ $team->team_description }}</textarea>
                                    <div class="invalid-feedback">
                                        Invalid description.
                                    </div>
                                </div>

                                <button class="mt-5 btn btn-primary btn-lg btn-block" type="submit">Update Team</button>

                            </div>
                        </form>
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
        window.onload = function() {
            var not_checkboxes = document.querySelectorAll('input[type="checkbox"]:not([checked])');
            not_checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });

            var checkboxes = document.querySelectorAll('input[type="checkbox"][checked]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = true;
            });
        };
    </script>
@endsection
