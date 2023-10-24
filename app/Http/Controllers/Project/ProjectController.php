<?php

namespace App\Http\Controllers\Project;

use App\Models\File;
use App\Models\Task;
use App\Models\Team;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Models\ProjectCategories;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
        /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Auth::user()->userCan("can_view_project")){
            abort(403);
        }

        if(Auth::user()->userCan("can_add_project")){
            $projects= Project::orderBy("updated_at","desc")->paginate(10);
        }
        else{
            $projects= Project::whereIn("team_id", Auth::user()->teamsIDs())->orderBy("updated_at","desc")->paginate(10);
        }

        // dd(Auth::user()->teamsIDs());
        
        return view("pm-dashboard.project.all-projects",['projects'=>$projects]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(!Auth::user()->userCan("can_add_project") ){
            abort(403);
        }
        
        $p_cats= ProjectCategories::select("id","cat_name")->get();
        $teams= Team::all();
        $tasks=[];
        return view("pm-dashboard.project.add-project",compact("p_cats", 'teams',"tasks"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::user()->userCan("can_add_project")){
            abort(403);
        }


        $validated= $request->validate(
            [
                "project_name" => "required|unique:projects",
                "project_category" => "required",
                "project_condition" => "required",
                "budget" => "required|numeric",
                "team_id" => "required",
                "project_image" => "nullable|image",
                'project_description'=>"required"

            ],
            [
                "project_name.required" => "Project Name is required",
                "project_name.unique" => strtoupper($request->project_name) . " is already added",
                "project_description.required" => "Project description is required",
                "project_status.required" => "Project Status is required",
                "budget.required" => "Project budget is required",
                "budget.numeric" => "Project budget must be a number",
                "team_id.required" => "You must select a Team",
                "project_category.required" => "Project Category is required",
                "project_image.image"=>"Project Image must be Image Type"
            ]

        );
 
       
        $project= Project::create($validated);

        if($request->file("project_image")){
        
            $path= $request->file("project_image")->storePublicly("public/project/images");
            if($path){
                $project_image= File::create([
                    "file_name"=>$request->file("project_image")->getClientOriginalName(),
                    "file_path"=> $path,
                    "file_type"=>$request->file("project_image")->getClientOriginalExtension(),
                    "parent_id"=> $project->id,
                    "model"=> Project::class   
                ]);

                if($project_image){
                    $project->project_image_id= $project_image->id;
                    $project->save();
                }
            }
        }


        $team= Team::findOrFail($validated['team_id']);

        $title="Your Team ( {$team->team_name} ) has been assigned a New Project";
        $link= route("project.edit", ["project",$project->id]);
        $content= "Please add Task and Assign to Users";

        sendNotifcation($team->team_lead_id, $title, $content, $link);

        return redirect()->route("project.edit",['project'=>$project->id])->with(["message" => "Project added successfully", "result" => "success"]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
         if(!Auth::user()->userCan("can_add_project") && !Auth::user()->belongsToProject($id) ){
            abort(403);
        }

        $p_cats= ProjectCategories::select("id","cat_name")->get();
        $teams= Team::all();
        $project= Project::findOrFail($id);
        
        $tasks= Task::where("project_id",$id)->get();
        return view("pm-dashboard.project.edit-project",compact("p_cats", 'teams','project','tasks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $project= Project::findOrFail($id);
        if(!Auth::user()->userCan("can_add_project") &&  !Auth::user()->isTeamLead($project->team_id)){
            abort(403);
        }

        $validated= $request->validate(
            [
                "project_name" => "required|unique:projects,project_name,$id",
                "project_category" => "required",
                "project_condition" => "required",
                "budget" => "required|numeric",
                "team_id" => "required",
                "project_image" => "nullable|image",
                'project_description'=>"required"

            ],
            [
                "project_name.required" => "Project Name is required",
                "project_name.unique" => strtoupper($request->project_name) . " is already added",
                "project_description.required" => "Project description is required",
                "project_status.required" => "Project Status is required",
                "budget.required" => "Project budget is required",
                "budget.numeric" => "Project budget must be a number",
                "team_id.required" => "You must select a Team",
                "project_category.required" => "Project Category is required",
                "project_image.image"=>"Project Image must be Image Type"
            ]

        );
 
       
        
        $update = $project->update($validated);

        if($request->file("project_image")){
        
            $old_file= File::where("id", $project->project_image_id)->first();

            
            $path= $request->file("project_image")->storePublicly("public/project/images");
            
            if($path!=""){

            
                if(null != $old_file){
                    $old_file_path= $old_file->file_path;
                    $project_image= $old_file->update([
                        "file_name"=>$request->file("project_image")->getClientOriginalName(),
                        "file_path"=> $path,
                        "file_type"=>$request->file("project_image")->getClientOriginalExtension()
                    ]);

                    Storage::delete($old_file_path);
                }
                else{
                    $project_image= File::create([
                        "file_name"=>$request->file("project_image")->getClientOriginalName(),
                        "file_path"=> $path,
                        "file_type"=>$request->file("project_image")->getClientOriginalExtension(),
                        "parent_id"=> $project->id,
                        "model"=> Project::class   
                    ]);
                }
                

                if($project_image){
                    $project->project_image_id= $old_file ? $old_file->id : $project_image->id;
                    $project->save();
                }

                
                
           
            }
        }


        return redirect()->back()->with(["message" => "Project Updated successfully", "result" => "success"]);
   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!Auth::user()->userCan("can_add_project")){
            abort(403);
        }


        echo "sdfg";
    }
}
