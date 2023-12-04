<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class AuthCLientAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $client= session()->get("client");

        $project_id= isset($request->project) ?  $request->project : ( ($_GET['project_id']) ? $_GET['project_id'] : "" );

 // $2y$10$KMo7kvWrIlY4U5qku.uA7.n0UzkOJTnPPFY8V8DKy3vwnDrA/PLb6
        if(($client!=null && isset($project_id) && $client->id==$project_id) || (Auth::check() && Auth::user()->role_id==1)){

            return $next($request);

        }
        
        return redirect()->route("client.verify");
    }
}
