<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable= [
                "ticket_name" ,
                'ticket_description' ,
                'ticket_deadline' ,
                'priority' ,
                "project_id" ,
                "reference_task_id" ,
                "has_attachments",
                "status" 
    ];


    public function project()
    {
        return $this->belongsTo( Project::class, 'project_id');
    }

    public function task(){
        return $this->belongsTo(Task::class,"reference_task_id",'id');
    }

     public function ticketLead(){
        return $this->belongsTo(User::class,"task_lead_id",'id');
    }


    public function attachments(){
        return File::where("parent_id", $this->id)->where("model",$this::class)->get();
    }
}
