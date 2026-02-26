<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text("message");

            $table->foreignId("sender_id")->references("id")->on("users")->onDelete("cascade");
            $table->foreignId("chat_id")->references("id")->on("chats")->onDelete("cascade");

            $table->time("time")->nullable();
            $table->date("date")->nullable();

            $table->boolean("has_attachments")->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
