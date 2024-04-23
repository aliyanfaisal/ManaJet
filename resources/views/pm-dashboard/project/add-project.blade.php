@extends('layouts.superadmin_app')

@section('content')
    <div class="container-fluid w-8">
        <div>
            <x-card title="Add a New Project" tab1="<a href='{{route('project.index')}}' class='btn btn-primary '>All Projects</a>" classes="border border-info">

                <div class="container-fluid px-md-5">

                    <x-display-errors />

                    <x-display-form-errors />
                    <form enctype="multipart/form-data" autocomplete="off" class="needs-validation row" novalidate="" method="post" action="{{ route('project.store') }}">
                        @csrf
                        <div class="col-md-4 order-md-2 mb-4">
                            <x-card title="Project Preview" classes="border border-info">
                                <div class="text-center">
                                    <img style="    max-width: 300px;width: 100%;" class="m-auto" id="project_image_preview" src="{{ asset('assets/images/logo.png') }}" alt="">
                                    <b class="badge badge-info position-absolute"
                                        style="left: 7px; top: 70px;  font-size: 20px;" ><span id="budget_preview">---</span> {{env("CURRENCY_SYMBOL",'PKR')}}</b>
                                    <h5 class="font-weight-bold my-3" style="text-transform: capitalize" id="project_name_preview">--------</h5>
                                    <hr>
                                    <div class="d-flex justify-content-between flex-wrap">
                                        <span><b class="badge badge-info fsize-1" id="project_category_preview">------</b></span>
                                        <span><b class="badge badge-warning fsize-1"  id="team_id_preview">---</b></span>
                                    </div>
                                </div>
                            </x-card>


                            <h5 class="mb-3">Project Status</h5>

                            <div class="d-block my-3">
                                <div class="custom-control custom-radio">
                                    <input id="project_condition_1" name="project_condition" type="radio"
                                        class="custom-control-input" value="publish" checked="" required="">
                                    <label class="custom-control-label"  for="project_condition_1">Publish</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input id="project_condition_2" name="project_condition" type="radio"
                                        class="custom-control-input" required="" value="draft">
                                    <label class="custom-control-label" for="project_condition_2">Draft</label>
                                </div>
                            </div>
                            <hr class="mb-4">
                            <button class="btn btn-primary btn-lg btn-block" type="submit">Save Project</button>


                        </div>
                        <div class="col-md-8 order-md-1">
                            <h4 class="mb-3">Project Details</h4>
                            <div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="project_name">Project Name</label>
                                        <input type="text" class="form-control" name="project_name" id="project_name"
                                            placeholder="Project Title" value="{{old('project_name')}}" required="">
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
                                                <option @selected(old('project_category')==$cat->id) value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
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
                                            placeholder="" value="{{old('budget')}}" required="">
                                        <div class="invalid-feedback">
                                            Budget field is required.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="team_id">Team</label>
                                        <select name="team_id" class="custom-select d-block w-100" id="team_id"
                                            required="">
                                            <option value="">Choose...</option>
                                            @foreach ($teams as $team)
                                                <option @selected(old('team_id')==$team->id) value="{{ $team->id }}">{{ $team->team_name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Team is required.
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-12  mb-3">
                                        <label for="project_image">Project Image</label>
                                        <input type="file" class=" form-control-file " value="{{old('project_image')}}" name="project_image"
                                            id="project_image">
                                        <div class="invalid-feedback">
                                            Invalid Image.
                                        </div>
                                        <hr>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="project_description">Project Description</label>
                                    <textarea rows="7" class="form-control" name="project_description" id="project_description"
                                        placeholder="Summary of the project" required="">{{old('project_description')}}</textarea>
                                    <div class="invalid-feedback">
                                        Invalid description.
                                    </div>
                                </div>


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
            
                $("#"+$this.attr("id")+"_preview").attr("src",e.target.result)
            };

            reader.readAsDataURL($this[0].files[0]);

        } 
    </script>
@endsection
