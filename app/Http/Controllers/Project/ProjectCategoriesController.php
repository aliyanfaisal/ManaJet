<?php

namespace App\Http\Controllers\Project;

use Illuminate\Http\Request;
use App\Models\ProjectCategories;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProjectCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!Auth::user()->userCan("can_add_project_category")){
            abort(403);
        }

        $p_cats = ProjectCategories::orderBy("id", "desc")->paginate(10);
        return view("pm-dashboard.project.all-project-categories", compact("p_cats"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("pm-dashboard.project.add-project-category");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(!Auth::user()->userCan("can_add_project_category")){
            abort(403);
        }
        
        $post = $request->post();
        $validate= $request->validate(
            [
                "cat_name" => "required|unique:project_categories,cat_name".(isset($request->id) ? ",".$request->id : ""),
                "parent_cat_id" => "nullable",
                "cat_description" => "nullable",

            ],
            [
                "cat_name.required" => "Category Name is required",
                "cat_name.unique" => strtoupper($post['cat_name']) . " is already added",
                "cat_description.required" => "Category description is required",
            ]

        );

        unset($post['_token']);

        if(isset($request->id)){
            $p_cat= ProjectCategories::findOrFail($request->id);
            $p_cat->update($validate);
            return redirect()->back()->with(["message" => "Category Updated successfully", "result" => "success"]);
        }

        $p_cat = ProjectCategories::create($post);

        return redirect()->back()->with(["message" => "Category added successfully", "result" => "success"]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(!Auth::user()->userCan("can_add_project_category")){
            abort(403);
        }


        $ProjectCategories= ProjectCategories::findOrFail($id);
        $ProjectCategories->delete();

        return redirect()->route("project-categories.index")->with(['message'=>"Project Deleted Successfully!","result"=>"success"]);
    }
}