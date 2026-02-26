<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Nette\Utils\Random;
use App\Models\TeamUsers;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Models\ProjectCategories;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if(!Auth::user()->userCan("can_add_user")){
            abort(403);
        }

        
        $users = User::orderBy("id", "desc")->paginate(10);
        return view("pm-dashboard.user.all-users", compact("users"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Auth::user()->userCan("can_add_user")){
            abort(403);
        }
        
        $roles = Role::where("status", "active")->get();
        $teams = Team::all();
        return view("pm-dashboard.user.add-user", compact('roles', 'teams'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::user()->userCan("can_add_user")){
            abort(403);
        }

        $validated = $request->validate(
            [
                "name" => 'required',
                "role_id" => "required",
                "email" => "required|email|unique:users,email",
                "team_ids" => "nullable",
                "phone" => "required",
                "profile_picture" => "nullable"
            ],
            [
                "name.required" => 'User Name is required',
                "role_id.required" => "User Role is required",
                "email.required" => "Email is required",
                "phone.required" => "User Phone is required"
            ]
        );
 

        $randPass = Random::generate(10);
        $validated['password'] = Hash::make($randPass);
        $user = User::create($validated);

        if (!$user) {
            return redirect()->back()->with([
                "message" => "Failed to add user, try again!.",
                "result" => "danger"
            ]);
        }

        if ($request->hasFile("profile_picture")) {
            $image = $request->file("profile_picture");

            $upload = $image->storePublicly("/public/user_profile_pictures");
            $profile = UserProfile::create([
                "user_id" => $user->id,
                "meta_key" => "profile_picture",
                "meta_value" => $upload
            ]);
        }


        //add user to teans
        if (isset($validated['team_ids'])) {

            if(is_array($validated['team_ids'])){

                foreach ($validated['team_ids'] as $team) {

                    if($team==""){
                        continue;
                    }
                    
                    $team_users = TeamUsers::create([
                        "team_id" => $team,
                        "user_id" => $user->id
                    ]);
                }
            }
            else{
                $team_users = TeamUsers::create([
                    "team_id" => $validated['team_ids'],
                    "user_id" => $user->id
                ]);
            }
        }

        return redirect()->route("users.edit", ['user' => $user->id])->with([
            "message" => "<b>User added successfully.</b><br><b>Email:</b> {$validated['email']}<br><b>Password:</b> {$randPass}<br><br><b>NOTE:</b> Provide these credentials to the user and ask them to change the password.",
            "result" => "success"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        if(!Auth::user()->userCan("can_add_user")){
            abort(403);
        }

        $roles = Role::where("status", "active")->get();
        $teams = Team::all();
        return view("pm-dashboard.user.edit-user", compact('user', "roles", 'teams'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if(!Auth::user()->userCan("can_add_user")){
            abort(403);
        }

        $validated = $request->validate(
            [
                "id" => "required",
                "name" => 'required',
                "role_id" => "required",
                "email" => "required|email",
                "team_ids" => "nullable",
                "phone" => "required",
                "profile_picture" => "nullable",
                "password"=>"nullable"
            ],
            [
                "id.required" => 'Failed to get User ID. Refresh page and try again!',
                "name.required" => 'User Name is required',
                "role_id.required" => "User Role is required",
                "email.required" => "Email is required",
                "phone.required" => "User Phone is required"
            ]
        );
 
        if( isset($validated['password']) && $validated['password'] !==""){
            $validated['password']= Hash::make($validated['password']);
        }
        else{
            unset($validated['password']);
        }

        $user = User::findOrFail($validated['id']);

        $user = $user->update($validated);

        if (!$user) {
            return redirect()->back()->with([
                "message" => "Failed to add user, try again!.",
                "result" => "danger"
            ]);
        }
        $user = User::findOrFail($validated['id']);

        if ($request->hasFile("profile_picture")) {
            $image = $request->file("profile_picture");

            $upload = $image->storePublicly("/public/user_profile_pictures");
            $old_profile = UserProfile::where("user_id", $user->id)->where("meta_key", "profile_picture")->first();

            if (null !== $old_profile) {
                Storage::delete($old_profile->meta_value);

                $old_profile->update([
                    "meta_value" => $upload
                ]);

            } else {
                $profile = UserProfile::create(
                    [
                        "user_id" => $user->id,
                        "meta_key" => "profile_picture",
                        "meta_value" => $upload
                    ]
                );
            }



        }


        //add user to teans
        $old_team_ids = [];
        if ($request->old_team_ids != "") {
            $old_team_ids = (array) json_decode($request->old_team_ids);
            $old_team_ids = array_unique($old_team_ids);
        }

        $team_to_remove_user = $old_team_ids;



        if (isset($validated['team_ids']) && $validated['team_ids'] != $old_team_ids) {
            $validated['team_ids'] = array_map("intval", $validated['team_ids']);

            $team_to_remove_user = array_diff($old_team_ids, $validated['team_ids']);

            $team_to_add_user = array_diff($validated['team_ids'], $old_team_ids);

            foreach ($team_to_add_user as $team) {
                if($team==""){
                    continue;
                }
                $team_users = TeamUsers::create([
                    "team_id" => $team,
                    "user_id" => $user->id
                ]);
            }
        }

        TeamUsers::whereIn("team_id", $team_to_remove_user)->where("user_id", $user->id)->delete();

        return redirect()->back()->with(["message" => "User Updated Successfully!", "result" => "success"]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!Auth::user()->userCan("can_add_user") ){
            abort(403);
        }


        $user= User::findOrFail($id);
        $user->delete();

        return redirect()->route("users.index")->with(["message" => "User Updated Successfully!", "result" => "success"]);
    }

    public function getUsers(Request $request)
    {

        $role_id = $request->get("user_id");

        if ($role_id) {
            return User::where("role_id", $role_id)->get();
        } else {
            return User::all();
        }

    }
}