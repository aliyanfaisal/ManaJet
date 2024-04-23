@extends('layouts.superadmin_app')

@section('content')
    <div class="container-fluid w-8">
        <div>
            <x-card title="Add a New Team" classes="border border-info">

                <div class="container-fluid px-md-5">

                    <x-display-errors />

                    <x-display-form-errors />

                    <div class="row" >
                        <form novalidate autocomplete="false" class="col-md-6 order-md-2 needs-validation">
                            <x-card title="Add Team Members" classes="w-100 border-info">
                                @if (Request::is('*/teams/create'))
                                    <div class="overlay-disable" style="">
                                    <h5><b>Add a Team first</b>.</h5>
                                    </div>
                                @endif
                                <div class="col-md-6 mb-3">
                                    <label for="">Add to Team</label>
                                    <select autocomplete="false" class="custom-select d-block w-100" id="add_to_team" required="">
                                        <option value="">Choose...</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Project name is required.
                                    </div>
                                </div>

                                <hr>
                                <div>
                                    <h5>Current Members</h5>
                                    <div class="d-flex flex-wrap">
                                        <div class="form-check mr-4">
                                            <input autocomplete="false" class="form-check-input" type="checkbox"
                                                value="" id="" checked>
                                            <label class="form-check-label" style="font-size: 16px" for="">
                                                Select Users
                                            </label>
                                        </div> 
                                    </div>
                                </div>
                                <button class="mt-5 btn btn-primary btn-lg btn-block" type="submit">Update Members</button>

                            </x-card>

                        </form>
                        <form novalidate class="col-md-6 order-md-1 needs-validation" method="post" action="{{route('teams.store')}}">
                            @csrf
                            <h4 class="mb-3">Team Details</h4>
                            <div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="team_name">Team Name</label>
                                        <input autocomplete="false" type="text" class="form-control" value="{{old('team_name')}}" name="team_name" id="team_name"
                                            placeholder="Team Name" value="" required="">
                                        <div class="invalid-feedback">
                                            Project name is required.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">

                                        <label for="category_id">Team Category</label>
                                        <select autocomplete="false" class="custom-select d-block w-100" name="category_id" id="category_id"
                                            required="">
                                            <option value="">Choose...</option>
                                            @foreach ($p_cats as $cat)
                                                <option @if(old('category_id')==$cat->id) selected @endif value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
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
                                        <select autocomplete="false" name="team_lead_id" class="custom-select d-block w-100" id="team_lead_id"
                                            required="">
                                            <option value="">Choose...</option>
                                            @foreach ($users as $user)
                                                <option @if(old('team_lead_id')==$user->id) selected @endif value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Team is required.
                                        </div>
                                    </div>

                                </div>

                                <div class="mb-3">
                                    <label for="team_description">Team Description</label>
                                    <textarea rows="7" class="form-control" name="team_description" id="team_description" placeholder="A brief description"
                                        required="">{{old("team_description")}}</textarea>
                                    <div class="invalid-feedback">
                                        Invalid description.
                                    </div>
                                </div>

                                <button class="mt-5 btn btn-primary btn-lg btn-block" type="submit">Save Team</button>

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

