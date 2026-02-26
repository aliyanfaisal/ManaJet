<?php

namespace App\Http\Controllers\UserRole;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RolePermissionController extends Controller
{
    

    public function index(){

        return view("pm-dashboard.user-role.all-roles");
    }
}
