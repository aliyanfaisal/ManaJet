@extends('layouts.superadmin_app', ['use_bootstrap_js' => true])

@section('content')
    <div class="row">
        <div class="col-md-12">
            <x-card title="All User Permissions" classes="border border-info">
                <div class="row">

                    <div class="table-responsive col-md-12">
                        <x-display-errors />

                        <x-display-form-errors />

                        <x-fancy-table>
                            <x-fancy-table-head>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Parent User Role</th>
                                    <th class="">Permissions</th>
                                    <th class="" style="min-width: 180px">Actions</th>
                                </tr>
                            </x-fancy-table-head>

                            <x-fancy-table-body>
                                @php
                                    $i = isset($_GET['page']) ? intval($_GET['page']) : 0;
                                    $i++;
                                @endphp
                                @foreach ($roles as $role)
                                    <tr>
                                        <td class="text-center text-muted">#{{ $i }}</td>
                                        <td>
                                            <div class="widget-content p-0">
                                                <div class="widget-content-wrapper">
                                                    <div class="widget-content-left flex2">
                                                        <div class="widgtext-centeret-heading"><b>{{ $role->role_name }}</b>
                                                        </div>
                                                        <div class="widget-subheading opacity-8">
                                                            {{ Str::limit($role->role_description, 40) }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        @php
                                            $permissions = $role->permissions();

                                            $role->permissions= $role->permission_ids();
                                        @endphp

                                        <td class=" ">
                                            @foreach ($permissions as $permission)
                                            @php
                                            
                                            @endphp
                                                <div class="badge badge-warning">{{ $permission->permission_name }}</div>
                                            @endforeach
                                        </td>

                                        <td class=" ">
                                            <button type="button" id="edit" data-json="{{ $role->toJson() }}"
                                                class="btn btn-primary btn-sm">
                                                Edit/View
                                            </button>

                                            <button type="button" class="btn btn-danger btn-sm">
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

                        <div class="mt-3">
                            {{$roles->links()}}
                            
                        </div>
                        
                    </div>


                </div>
            </x-card>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="edit_form_modal" data-bs-backdrop="false"  style="top: 60px">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="role_title_modal">Edit Role</h5>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">Close</button>
                </div>
                <div class="modal-body">
                    <form autocomplete="off" class="needs-validation" novalidate="" method="post"
                        action="{{ route('permissions.store') }}" id="main_form">
                        @csrf
                        <input type="text" name="id" hidden>
                        <x-card title="Edit Role" classes="border border-info">
                            <div class="">

                                <div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="role_name">User Role</label>
                                            <input readonly type="text" class="form-control" id="role_name" name="role_name"
                                                placeholder="Role Name">
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label for="">Role Permissions</label>
                                            <div class="d-flex flex-wrap">
                                                <input hidden type="text" name="old_permissions" id="old_permissions">
                                                @foreach ($permissions_all as $permission)
                                                    <div class="custom-control custom-checkbox mr-4">
                                                        <input autocomplete="false" class="custom-control-input" type="checkbox"
                                                            name="permissions[]" value="{{ $permission->id }}"
                                                            id="per_{{ $permission->id }}" >
                                                        <label class="custom-control-label " style="font-size: 16px"
                                                            for="per_{{ $permission->id }}">
                                                            {{ $permission->permission_name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>


                                    <button class="btn btn-primary btn-lg btn-block" type="submit">Update
                                        Role Permissions</button>


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
        var myModal = new bootstrap.Modal(document.getElementById('edit_form_modal'), {
            keyboard: false
        })

        $(document).on("click", "#edit", function() {
            var $json = $(this).data("json")

            console.log($json)
            $("#role_title_modal").html($json['role_name'])
            for ($field in $json) {
                const ele = $("#main_form").find("[name='" + $field + "'], [name='" + $field + "[]']")

                console.log("ele",ele)

                if (ele.length > 0) { 

                    if (ele.prop("tagName").toLowerCase() == "select" && ele.attr("name") == "parent_id") {
                        //remove the same rile from parent
                        ele.find("[value='" + $json['id'] + "']").remove()
                    }
                    
                    if (ele.attr("name")=="permissions[]") {
                        
                        $("#old_permissions").val( JSON.stringify($json['permissions']))

                        ele.each(function(){
                            let ele1= $(this)
                            
                            // console.log("yeahhh",ele1)
                            //     console.log("value" , ele1.attr("value"))
                            ele1.removeAttr("checked")

                            if ( $json['permissions'].includes(parseInt(ele1.attr("value"))) ) {
                                
                                ele1.click()
                            }
                        })
                        
                    }else{
                        ele.val($json[$field])
                    }

                }


            }
            myModal.show()
        })
    </script>
@endsection
