<?php

namespace App\Http\Controllers\UserRole;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
     
    public function index(){

        $roles= Role::orderBy("id", "desc")->paginate(20);

        return view("pm-dashboard.user-role.all-roles" , compact("roles"));
    }


    public function store(Request $request){


        if(isset($request->id)){
            return $this->update($request);
        }

        $validated= $request->validate(
            [
                'id'=>"nullable",
                "role_name" => "required|unique:roles",
                "parent_id" => "nullable",
                "role_description" => "nullable",
                "status"=>"nullable"

            ],
            [
                "role_name.required" => "Role Name is required",
                "role_name.unique" => strtoupper($request->role_name) . " is already added"
            ]

        );

    
        $role= Role::create($validated);

        return redirect()->back()->with(["message" => "Role added successfully", "result" => "success"]);
    }

    public function update( Request $request){

        $validated= $request->validate(
            [
                'id'=>"required",
                "role_name" => "required",
                "parent_id" => "nullable",
                "role_description" => "nullable",
                "status"=>"nullable"

            ],
            [
                "role_name.required" => "Role Name is required",
                "role_name.unique" => strtoupper($request->role_name) . " is already added"
            ]

        );
        
        $role= Role::findOrFail($validated['id']);
        $role= $role->update($validated);
        return redirect()->back()->with(["message" => "Role updated successfully", "result" => "success"]);
    }
}

