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
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->string("chat_name", 500)->nullable();
            $table->boolean("isGroup")->nullable()->default(0);

            $table->foreignId("sender_id")->nullable()->references("id")->on("users")->onDelete("cascade");
            $table->foreignId("receiver_id")->nullable()->references("id")->on("users")->onDelete("cascade");
            $table->foreignId("team_id")->nullable()->references("id")->on("teams")->onDelete("cascade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chats');
    }
};
