<?php

namespace App\Http\Controllers\UserRole;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\RolePermission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{

    public function index()
    {

        if(!Auth::user()->userCan("can_add_role") ){
            abort(403);
        }

        $roles = Role::orderBy("id", "desc")->paginate(10);

        return view("pm-dashboard.user-role.all-roles", compact("roles"));
    }


    public function store(Request $request)
    {
        if(!Auth::user()->userCan("can_add_role") ){
            abort(403);
        }

        if (isset($request->id)) {
            return $this->update($request);
        }

        $validated = $request->validate(
            [
                'id' => "nullable",
                "role_name" => "required|unique:roles",
                "parent_id" => "nullable",
                "role_description" => "nullable",
                "status" => "nullable"

            ],
            [
                "role_name.required" => "Role Name is required",
                "role_name.unique" => strtoupper($request->role_name) . " is already added"
            ]

        );


        $role = Role::create($validated);

        $default_permissions = config("default_permissions", [7, 8, 9, 10, 11]);
        foreach ($default_permissions as $per) {
            RolePermission::create([
                "role_id" => $role->id,
                "permission_id" => $per
            ]);
        }


        return redirect()->back()->with(["message" => "Role added successfully", "result" => "success"]);
    }

    public function update(Request $request)
    {
        if(!Auth::user()->userCan("can_add_role") ){
            abort(403);
        }
        $validated = $request->validate(
            [
                'id' => "required",
                "role_name" => "required",
                "parent_id" => "nullable",
                "role_description" => "nullable",
                "status" => "nullable"

            ],
            [
                "role_name.required" => "Role Name is required",
                "role_name.unique" => strtoupper($request->role_name) . " is already added"
            ]

        );

        $role = Role::findOrFail($validated['id']);
        $role = $role->update($validated);
        return redirect()->back()->with(["message" => "Role updated successfully", "result" => "success"]);
    }
}

