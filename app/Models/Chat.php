<?php

namespace App\Models;

use App\Models\Message;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    protected $fillable= [
        "chat_name",
        "sender_id",
        "receiver_id",
        "isGroup",
        "team_id"
    ];


    public function messages(){
        return $this->hasMany(Message::class,"chat_id");
    }
}
