@extends('layouts.superadmin_app')

@section('content')
    <div class="container-fluid w-8">
        <div>
            <x-card title="Edit User " tab1="<button data-id='delete_user' class='btn btn-danger delete_res_btn'>Delete User</button>"
                classes="border border-info">

                <div class="container-fluid px-md-5">
                   
                    <x-resource-delete-btn :id="$user->id" idx="delete_user" resource="users" resourceSingle="user"/>

                    <form autocomplete="off" class="needs-validation row" novalidate="" method="post"
                        enctype="multipart/form-data" action="{{ route('users.update', ['user' => $user->id]) }}">
                        @csrf
                        @method('put')

                        <input type="text" hidden value="{{ $user->id }}" name="id">
                        <div class="col-md-4 order-md-2 mb-4">

                            <x-card :title="$user->name" classes="border border-info">
                                <div class="text-center">
                                    <img class="m-auto" id="profile_picture_preview" src="{{ $user->profileImageUrl() }}"
                                        width="200" alt="">
                                    <h5 class="font-weight-bold my-3" id="name_preview">{{ $user->name }}</h5>
                                    <hr>
                                    <div class="d-flex justify-content-between">
                                        <span><b class="badge badge-info fsize-1"
                                                id="role_id_preview">{{ $user->role->role_name }}</b></span>
                                        <span><b class="badge badge-warning fsize-1" id="team_id_preview">In <span
                                                    class="text-danger">{{ count($user->teams) }}</span> Teams</b></span>
                                    </div>
                                </div>
                            </x-card>



                        </div>
                        <div class="col-md-8 order-md-1">

                            <x-display-errors />

                            <x-display-form-errors />
                            <div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name " class="required">User Name</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="User Name" value="{{ $user->name }}" required="">
                                        <div class="invalid-feedback">
                                            User name is required.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">

                                        <label for="role_id" class="required">User Role</label>
                                        <select class="custom-select d-block w-100" name="role_id" id="role_id"
                                            required="">
                                            <option value="">Choose...</option>
                                            @foreach ($roles as $role)
                                                <option @if ($user->role_id == $role->id) selected @endif
                                                    value="{{ $role->id }}">{{ $role->role_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a Role.
                                        </div>


                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">

                                        <label for="email" class="required">E-mail</label>
                                        <input type="email" class="form-control" id="email"
                                            placeholder="A vaild Email" value="{{ $user->email }}" name="email"
                                            required="">
                                        <div class="invalid-feedback">
                                            Email field is required.
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="required">Phone</label>
                                        <input type="phone" name="phone" class="form-control" id="phone"
                                            placeholder="Phone Number" value="{{ $user->phone }}" required="">
                                        <div class="invalid-feedback">
                                            Invalid Phone.
                                        </div>
                                    </div>


                                </div>

                                <div class="row ">
                                    <div class="col-md-6 mb-3">
                                        <label for="team_ids">Team</label>

                                        <select multiple name="team_ids[]" class="custom-select d-block w-100"
                                            id="team_ids">
                                            <option value="">Choose...</option>
                                            @foreach ($teams as $team)
                                                <option @selected(in_array($team->id, $user->teamsIds()->toArray())) value="{{ $team->id }}">
                                                    {{ $team->team_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="text-muted">
                                            Hold CTRL to select
                                        </div>
                                        <input hidden type="text" name="old_team_ids"
                                            value="{{ $user->teamsIds()->toJson() }}">
                                        <div class="invalid-feedback">
                                            Team is required.
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="profile_picture">User Image</label>
                                        <input type="file" class=" form-control-file " name="profile_picture"
                                            id="profile_picture">
                                        <div class="invalid-feedback">
                                            Invalid Image.
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name " >Password</label>
                                        <input type="pass" class="form-control" name="password" id="pass"
                                            placeholder="Enter a Password to reset, otherwise leave empty" value="" >
                                         
                                    </div>
                                </div>


                                <hr class="mb-4">
                                <button class="btn btn-primary btn-lg btn-block" type="submit">Update User</button>
                            </div>
                        </div>
                    </form>
                    
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

            if ($id.includes("id")) {
                value = $("#" + $id + " option[value='" + value + "']").html()

            } else {

            }

            console.log("va;", value)

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
@endsection
