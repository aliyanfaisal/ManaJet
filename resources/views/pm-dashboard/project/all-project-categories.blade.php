@extends('layouts.superadmin_app', ['use_bootstrap_js' => true])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card title="All Projects Categories" classes="border border-info">
                <div class="row">

                    <div class="col-md-4">
                        <form class="needs-validation" novalidate="" method="post"
                            action="{{ route('project-categories.store') }}">
                            @csrf
                            <x-card title="Add New Category" classes="border border-info">
                                <div class="">

                                    <x-display-errors />

                                    <x-display-form-errors />
                                    <div>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="cat_name">Category Name</label>
                                                <input type="text" class="form-control" name="cat_name" id="cat_name"
                                                    placeholder="Category Name" value="{{ old('cat_name') }}"
                                                    required="">
                                                <div class="invalid-feedback">
                                                    Category name is required.
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">

                                                <label for="parent_cat_id">Parent Category</label>
                                                <select class="custom-select d-block w-100" name="parent_cat_id"
                                                    id="parent_cat_id">
                                                    @php
                                                        $pp_cats = $p_cats->filter(function ($value, $key) {
                                                            if ($value->parent_cat_id == '') {
                                                                return true;
                                                            }
                                                        });
                                                    @endphp
                                                    <option value="">Choose...</option>
                                                    @foreach ($pp_cats as $cat)
                                                        <option @if (old('parent_cat_id') == $cat->id) selected @endif
                                                            value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
                                                    @endforeach

                                                </select>
                                                <div class="invalid-feedback">
                                                    Invalid Parent Category.
                                                </div>


                                            </div>
                                        </div>

                                        <div>
                                            <label for="cat_description">Category Description</label>
                                            <textarea class="form-control mb-3" name="cat_description" id="cat_description" rows="5">{{ old('cat_description') }}</textarea>
                                        </div>

                                        <button class="btn btn-primary btn-lg btn-block" type="submit">Add
                                            Category</button>


                                    </div>
                                </div>
                            </x-card>
                        </form>


                    </div>
                    <div class="table-responsive col-md-8">

                        <x-fancy-table>
                            <x-fancy-table-head>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Name</th>
                                    <th class="text-center">Parent Category</th>
                                    <th class="text-center">Description</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </x-fancy-table-head>

                            <x-fancy-table-body>
                                @php
                                    $i = isset($_GET['page']) ? intval($_GET['page']) : 0;
                                    $i++;
                                @endphp
                                @foreach ($p_cats as $cat)
                                    <tr>
                                        <td class="text-center text-muted">#{{ $i }}</td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left flex2">
                                                        <div class="widget-heading">{{ $cat->cat_name }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @php
                                            $parentCat = $cat->parentCategory();
                                        @endphp

                                        <td class="text-center">
                                            @if ($parentCat)
                                                <div class="badge badge-info">{{ $parentCat->cat_name }}</div>
                                            @endif
                                        </td>

                                        <td class="text-center">
                                            <div class="widget-subheading opacity-7">
                                                {{ Illuminate\Support\Str::limit($cat->cat_description, 30) }}
                                            </div>
                                        </td>

                                        <td class="">
                                            <button type="button" id="edit" data-json="{{ $cat->toJson() }}"
                                                class="btn btn-primary btn-sm">
                                                Edit/View
                                            </button>

                                            <span>
                                                <x-resource-delete-btn :id="$cat->id"
                                                    idx="project_cat_del_{{ $cat->id }}" resource="project-categories"
                                                    resourceSingle="project_category" />


                                                <button onclick="deleteResource('project_cat_del_{{ $cat->id }}')"
                                                    type="button" class="btn btn-danger btn-sm">
                                                    Delete 
                                                </button>
                                            </span>


                                        </td>
                                    </tr>

                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </x-fancy-table-body>
                        </x-fancy-table>
                        <div class="mt-3">
                            {{ $p_cats->links() }}

                        </div>
                    </div>


                </div>
            </x-card>
        </div>
    </div>




    <div class="modal" tabindex="-1" id="edit_form_modal" data-bs-backdrop="false" style="top: 60px">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cat_title_modal">Edit Role</h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" novalidate="" id="main_form" method="post"
                        action="{{ route('project-categories.store') }}">
                        @csrf
                        <input hidden name="id">
                        <x-card title="Add New Category" classes="border border-info">
                            <div class="">

                                <x-display-errors />

                                <x-display-form-errors />
                                <div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="cat_name">Category Name</label>
                                            <input type="text" class="form-control" name="cat_name" id="cat_name"
                                                placeholder="Category Name" required="">
                                            <div class="invalid-feedback">
                                                Category name is required.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">

                                            <label for="parent_cat_id">Parent Category</label>
                                            <select class="custom-select d-block w-100" name="parent_cat_id"
                                                id="parent_cat_id">
                                                @php
                                                    $pp_cats = $p_cats->filter(function ($value, $key) {
                                                        if ($value->parent_cat_id == '') {
                                                            return true;
                                                        }
                                                    });
                                                @endphp
                                                <option value="">Choose...</option>
                                                @foreach ($pp_cats as $cat)
                                                    <option value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
                                                @endforeach

                                            </select>
                                            <div class="invalid-feedback">
                                                Invalid Parent Category.
                                            </div>


                                        </div>
                                    </div>

                                    <div>
                                        <label for="cat_description">Category Description</label>
                                        <textarea class="form-control mb-3" name="cat_description" id="cat_description" rows="5">{{ old('cat_description') }}</textarea>
                                    </div>

                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Update
                                        Category</button>


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



@section("js")
<x-hide-sidebar-on-load></x-hide-sidebar-on-load>
@endsection




@section('js')
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('edit_form_modal'), {
            keyboard: false
        })

        $(document).on("click", "#edit", function() {
            var $json = $(this).data("json")


            $("#cat_title_modal").html($json['role_name'])
            for ($field in $json) {
                const ele = $("#main_form").find("[name='" + $field + "']")
                console.log("json", ele)
                if (ele.length > 0) {

                    if (ele.prop("tagName").toLowerCase() == "select" && ele.attr("name") == "parent_id") {
                        //remove the same rile from parent
                        ele.find("[value='" + $json['id'] + "']").remove()
                    }

                    if (ele.attr("name") == "status") {

                        ele.each(function() {
                            let ele1 = $(this)
                            ele1.removeAttr("checked")
                            if (ele1.attr("value") == $json['status']) {
                                console.log(ele1, $json['status'])
                                ele1.click()
                            }
                        })

                    } else {
                        ele.val($json[$field])
                    }

                }


            }
            myModal.show()
        })
    </script>
@endsection
