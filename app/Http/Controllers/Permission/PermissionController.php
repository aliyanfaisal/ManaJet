<?php

namespace App\Http\Controllers\Permission;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Models\RolePermission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        if(!Auth::user()->userCan("can_add_permission") ){
            abort(403);
        }


        $roles = Role::where("parent_id",null)->where("id","!=",1)->paginate(10);
        $permissions_all= Permission::all();
        return view("pm-dashboard.permission.all-permissions", compact("roles", "permissions_all"));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::user()->userCan("can_add_permission") ){
            abort(403);
        }
        
        if(!Auth::user()->userCan("can_add_permission") ){
            abort(403);
        }

        $validated = $request->validate(
            [
                "permissions" => 'nullable',
                "id" => "required"
            ],
            [
                "name.required" => 'User Name is required'
            ]
        );


        //add user to teans
        $old_permissions_ids = [];
        if ($request->old_permissions != "") {
            
            $old_permissions_ids = (array) json_decode($request->old_permissions);
            $old_permissions_ids = array_unique($old_permissions_ids);
        }

        $permissions_to_remove = $old_permissions_ids;

        if (isset($validated['permissions']) && $validated['permissions'] != $old_permissions_ids) {
            $validated['permissions'] = array_map("intval", $validated['permissions']);

            $permissions_to_remove = array_diff($old_permissions_ids, $validated['permissions']);

            $permissions_to_add = array_diff($validated['permissions'], $old_permissions_ids);

            foreach ($permissions_to_add as $per_id) {
                $team_users = RolePermission::create([
                    "permission_id" => $per_id,
                    "role_id" => $validated['id']
                ]);
            }
        }

        RolePermission::whereIn("permission_id", $permissions_to_remove)->where("role_id", $validated['id'])->delete();


        return redirect()->back()->with([
            "message" => "Permissions Updated!",
            "result"=>"success"
        ]);
    }


}
