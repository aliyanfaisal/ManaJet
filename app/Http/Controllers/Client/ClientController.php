<?php

namespace App\Http\Controllers\CLient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    //


    function verify(){
        return view("client.login-project");
    }


    function verifySecret(Request $request){

        $request->validate([
            "secret_key"=>"required"
        ]);


        $projects= Project::all();

        foreach($projects as $project){

            $check = Hash::check($project->project_name, $request->secret_key);

            if($check){
                session()->put("client", $project);
                return redirect()->route("project.client",['project'=>$project->id]);
            }
        }


        return redirect()->back()->with(['message'=>"No Project with this Secret Key!"]);

    } 
}
