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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId("project_id")->references("id")->on("projects")->onDelete("cascade")->nullable();

            $table->string("task_name", 150);
            $table->text("task_description")->nullable();
            $table->dateTime("task_deadline")->nullable();

            $table->foreignId("task_lead_id")->nullable()->references("id")->on("users")->nullOnDelete();

            $table->string("priority", 20);
            $table->integer("task_step_no")->nullable();

            $table->string("status", 20)->default("pending");

            $table->boolean("has_attachments")->default(0);
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
