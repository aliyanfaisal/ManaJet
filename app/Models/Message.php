<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable= [
        "message",
        "sender_id",
        "time",
        "has_attachments",
        "date",
        "chat_id"
    ];


    public function getAttachmentUrl(){
        
        $path = "";
        $attachemt= File::where("parent_id", $this->id)->where("model",$this::class)->first();

        if ($attachemt!=null) {
            $path = $attachemt->file_path;
        } else {
            $path = "default-user-profile.png";
        }


        return Storage::url($path);
    }
}
