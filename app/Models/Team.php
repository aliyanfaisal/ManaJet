<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        "team_name",
        "category_id",
        "team_lead_id",
        'team_description'
    ];


    public function teamLead()
    {
        return $this->belongsTo(User::class, "team_lead_id", "id");
    }

    public function category()
    {
        return $this->belongsTo(ProjectCategories::class, "category_id", "id");
    }

    public function members()
    {
        return $this->hasMany(TeamUsers::class);
    }

    public function membersData(){
        return $this->belongsToMany(User::class,"team_users","team_id","user_id");
    }

    public function getMemberIDs()
    {
        return $this->members->map(function ($item, $key) {
            return $item->user_id;
        })->toArray();
    }


    public function completedProjects(){
        return Project::where("team_id", $this->id)->where("project_status","complete")->count();
    }
}