<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class                                                                                                               Project extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];  
    protected $fillable = [
        "project_name",
        "project_category",
        "project_status",
        "budget",
        "team_id",
        "project_image_id",
        'project_description',
        'project_condition'
    ];


    public function progress(){

        $all_completed_tasks = Task::where("project_id",$this->id)->where("status",'complete')->count();
        $all_pending_tasks= Task::where("project_id",$this->id)->where("status",'!=','complete')->count();

        $total_tasks= intval($all_completed_tasks)+intval($all_pending_tasks);

        if($total_tasks>0){
            $percentage= ($all_completed_tasks/$total_tasks) * 100;
        }
        else{
            $percentage=0;
        }
        
        $color="info";

        if($percentage < 30){
            $color="danger";
        }
        elseif($percentage < 60){
            $color="warning";
        }
        elseif($percentage < 80){
            $color="info";
        }
        elseif($percentage < 100){
            $color="primary";
        }
        elseif($percentage==100){
            $color="success";
        }

        return [
            "completed_tasks"=>$all_completed_tasks,
            "pending_tasks" =>$all_pending_tasks,
            "total_tasks"=> $total_tasks,
            "progress_percentage"=>$percentage,
            "status_color"=>$color
        ];
    }
    public function category(){
        return $this->belongsTo(ProjectCategories::class,"project_category","id");
    }

    public function team(){
        return $this->belongsTo(Team::class,"team_id","id");
    }

    public function projectImage(){
        return $this->belongsTo(File::class,"project_image_id",'id');
    }

    public function projectImageUrl(){

        $path= ($this->projectImage)? $this->projectImage->file_path : "default-image.png";

        return Storage::url($path);
    }

    public function hasTask($task_name){
        $task= Task::where("project_id",$this->id)->where("task_name", $task_name)->first();

        if($task!=null){
            return true;
        }

        return false;
    }


    public function hasTasks(){
        $tasks= Task::where("project_id",$this->id)->count();

        if($tasks > 0){
            return true;
        }
        else{
            return false;
        }
    }

    public function tasks(){
        return $this->hasMany(Task::class,"project_id");
    }


}
