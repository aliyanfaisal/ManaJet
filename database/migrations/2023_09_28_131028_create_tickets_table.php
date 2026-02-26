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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId("project_id")->references("id")->on("projects")->onDelete("cascade")->nullable();

            $table->string("ticket_name", 150);
            $table->text("ticket_description")->nullable();
            $table->dateTime("ticket_deadline")->nullable();

            $table->foreignId("reference_task_id")->nullable()->references("id")->on("tasks")->nullOnDelete();

            $table->string("priority", 20);
            $table->string("status", 20);
            $table->boolean("has_attachments")->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
