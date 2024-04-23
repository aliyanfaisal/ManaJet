<?php

namespace App\Http\Controllers\Chat;

use App\Models\Chat;
use App\Models\File;
use App\Models\Team;
use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    //

    public function index()
    {
        $team_members= User::all();
        if (Auth::user()->role_id != 1)  {
            $team_ids = Auth::user()->teamsIDs()->toArray();

            foreach($team_members as $key=>$mem){
                $memTeams= $mem->teamsIDs()->toArray();

                $intersection = array_intersect($team_ids, $memTeams);

                if (empty($intersection)) {

                    unset($team_members[$key]);
                }
            }

        }

      

        $chats= [];
        $chat_sender= Chat::where("sender_id",Auth::user()->id)->get();
        $chat_receiver= Chat::where("receiver_id", Auth::user()->id)->get();

        
        if($chat_sender->isNotEmpty()){
            $chats= $chat_sender->merge($chat_receiver);
        }
        else{
            $chats=  ($chat_receiver);
        }
    

        return view("chat.index", compact("team_members","chats"));
    }


    public function showMessages(Request $request){

        $team_members= User::all();
        if (Auth::user()->role_id != 1)  {
            $team_ids = Auth::user()->teamsIDs()->toArray();

            foreach($team_members as $key=>$mem){
                $memTeams= $mem->teamsIDs()->toArray();

                $intersection = array_intersect($team_ids, $memTeams);

                if (empty($intersection)) {
                    unset($team_members[$key]);
                }
            }

        }


        $chats= [];
        $chat_sender= Chat::where("sender_id",Auth::user()->id)->get();
        $chat_receiver= Chat::where("receiver_id", Auth::user()->id)->get();

        
        if($chat_sender->isNotEmpty()){
            $chats= $chat_sender->merge($chat_receiver);
        }
        else{
            $chats=  ($chat_receiver);
        }
    
        

        $curr_user= User::findOrFail($request->id);


        return view("chat.index", compact("team_members",'curr_user',"chats"));
    }


    public function sendMessages(Request $request){

        if(!isset($request->send_to_id)){
            return redirect()->back();
        }

        $with_user_id= $request->send_to_id;
        $with_user= User::findOrFail($with_user_id);

        $chat= Chat::where("sender_id",Auth::user()->id)->where("receiver_id", $with_user_id)->first();

        if($chat==null){
            $chat= Chat::where("sender_id",$with_user_id)->where("receiver_id", Auth::user()->id)->first();
        }
        
        if($chat==null){
            $chat= chat::create([
                "chat_name"=> Str::title($with_user->name) . " & ". Str::title(Auth::user()->name),
                "sender_id"=> Auth::user()->id  ,
                "receiver_id"=>$with_user_id,
            ]);
        }

        $has_attachments= false;

        $message= Message::create([
            'message'=>$request->message,
            "chat_id"=>$chat->id,
            "sender_id"=>Auth::user()->id,
            "time"=> date("H:i:s"),
            "date"=>date("Y-m-d"),
            "has_attachments"=> $has_attachments
        ]);


        if($request->hasFile("upload")){
         
            $path= $request->file("upload")->storePublicly("public/chat/images");
            if($path){
                $file= File::create([
                    "file_name"=>$request->file("upload")->getClientOriginalName(),
                    "file_path"=> $path,
                    "file_type"=>$request->file("upload")->getClientOriginalExtension(),
                    "parent_id"=> $message->id,
                    "model"=> Message::class   
                ]);

                if($file){
                    $message->has_attachments= true;
                    $message->save();
                }
            }
        }

 

        return redirect()->route("chat.show", ["id"=>$with_user_id]);

    }
}
