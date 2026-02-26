<?php

namespace App\Http\Controllers\NoticeBoard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NoticeBoard;
use App\Models\Project;
use App\Models\Team;

class NoticeBoardController extends Controller
{
    
    public function store(Request $request){

        $validated= $request->validate([
            "notice_title"=>"required",
            "notice_content"=>"required",
            "project_id"=>"required"
        ]);


        $notice= NoticeBoard::create($validated);


        $project= Project::findOrFail($validated['project_id']);

        $team_members= Team::findOrFail( $project->team_id )->members;

        foreach($team_members as $mem){

            $title="New Notice:( {$notice->notice_title} ) has been added to Project ( {$project->project_name} )";
            $link= route("project.edit", ["project",$project->id]);
            $content= $notice->notice_content;

            sendNotifcation($mem->user_id, $title, $content, $link);

        }


        return redirect()->back()->with(['message'=>"Notice Sent Successfully!", "result"=>"success"]);
    }


    public function destroy(Request $request, $id){

        $notice= NoticeBoard::findOrFail($id);

        $notice->delete();

        return redirect()->back()->with(['message'=>"Notice Deleted!", "result"=>"success"]);
    }
}
