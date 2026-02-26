<?php

namespace App\Http\Controllers\Option;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
Use App\Models\Option;

class OptionController extends Controller
{
    //

    public function index(Request $request){

        $options= Option::whereNot("option_key","like","%generated%")->get();

        $options_array=[];

        foreach($options as $option){
            $options_array[$option->option_key]= $option->option_value;
        }
 
        return view("pm-dashboard.option.options", ['options'=>$options_array]);
    }



    public function store(Request $request){

        $validated= $request->validate([
            "application_name"=>"required", 
        ]);


        $validated= $request->post();

        unset($validated['_token']);


            if($request->hasFile("application_logo")){

                $logo= $request->file("application_logo");

                $path= $logo->storePublicly("/public/application/images");

                if($path){

                    $validated['application_logo']= $path;
                }
            }


        foreach($validated as $key=>$field){

            $option= Option::where("option_key",$key)->first();

            if($option!=null){

                $option->update([ 
                    "option_value"=>$field
                ]);

            }
            else{

                $option= Option::create([
                    "option_key"=>$key,
                    "option_value"=>$field,
                    "active"=>"active"
                ]);

            } 
            
        }



        return redirect()->back()->with(['message'=>"Options Updated!"]);

    }
}
