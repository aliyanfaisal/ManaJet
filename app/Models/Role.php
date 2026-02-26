<?php

namespace App\Models;

use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['role_name', 'parent_id', 'role_description', 'status'];


    public function parentRole()
    {

        if ($this->parent_id) {
            return self::find($this->parent_id);
        } else {
            return false;
        }
    }

    public function permissions(){
        $parent_id= $this->parentRole();

        if($parent_id){
            $role_id= $parent_id->id;
        }
        else{
            $role_id= $this->id;
        }

        return  $permissions = RolePermission::where('role_id', $role_id)
                        ->leftJoin('permissions', 'role_permissions.permission_id', '=', 'permissions.id')
                        ->get();
    }


    public function permission_ids(){
        $parent_id= $this->parentRole();

        if($parent_id){
            $role_id= $parent_id->id;
        }
        else{
            $role_id= $this->id;
        }


        return  $permissions = RolePermission::where('role_id', $role_id)
                        ->leftJoin('permissions', 'role_permissions.permission_id', '=', 'permissions.id')
                        ->pluck("permission_id");
    }
    
}