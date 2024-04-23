<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Team;
use App\Models\TeamUsers;
use App\Models\Permission;
use App\Models\Notification;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Storage;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'role_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function profile()
    {
        return $this->hasMany(UserProfile::class, "user_id", 'id');
    }



   public function userCan($permission)
    {

        $userPermissions = $this->role->permission_ids()->toArray();

        $checkPermission = Permission::where("permission_name", $permission)->pluck("id")->toArray();
    
        
        if (isset($checkPermission[0])) {

            return in_array($checkPermission[0], $userPermissions);

        }

        return false;

    }

    public function isATeamLead()
    {

        $isTeamLead = Team::where("team_lead_id", $this->id)->first();

        if ($isTeamLead) {
            return true;
        }

        return false;
    }

    public function profileData()
    {

        $data = [];
        foreach ($this->profile as $p_data) {
            $data[$p_data['meta_key']] = $p_data['meta_value'];
        }

        return $data;
    }

    public function profileImageUrl()
    {
        $path = "";
        if (isset($this->profileData()['profile_picture'])) {
            $path = $this->profileData()['profile_picture'];
        } else {
            $path = "default-user-profile.png";
        }


        return Storage::url($path);
    }
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function teams()
    {
        return $this->hasMany(TeamUsers::class, "user_id", "id");
    }

    public function teamsIDs()
    {
        $team_ids=  TeamUsers::where("user_id", $this->id)->pluck("team_id");
        $teams_where_lead= Team::where("team_lead_id", $this->id)->pluck("id");

        if(isset($teams_where_lead)){
            foreach($teams_where_lead as $id_){
                $team_ids->push($id_);
            }
        }
        
        return $team_ids;
    }

    public function belongsToTeam($team_id)
    {
        $team_user = TeamUsers::where("team_id", $team_id)->where("user_id", $this->id)->first();

        if ($team_user) {
            return true;
        }
        return false;
    }

    public function belongsToProject($project_id){

        $project= Project::findOrFail($project_id);
        return $this->belongsToTeam($project->team_id);
    }


    public function isTeamLead( $team_id ){
        $team= Team::findOrFail($team_id);
        return in_array( $this->id,$team->getMemberIDs());
    }


    public function leadOfTeams(){
       return $team_lead= Team::where("team_lead_id",$this->id)->get();
    }


    public function messagesWith($with_user_id){

        $chat= Chat::where("sender_id",$this->id)->where("receiver_id", $with_user_id)->first();

        if($chat==null){
            $chat= Chat::where("sender_id",$with_user_id)->where("receiver_id", $this->id)->first();
        }

        $msgs=null;
        if($chat!=null){
            $msgs= Message::where("chat_id", $chat->id)->get();
        }

        return $msgs;
    }


    public function notifications(){
        return $this->hasMany(Notification::class,"user_id");
    }

}