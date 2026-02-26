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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string("project_name", 150);
            
            $table->text("project_description")->nullable();

            $table->string("budget",20);

            $table->foreignId("project_category")->nullable()->references("id")->on("project_categories")->nullOnDelete();

            $table->foreignId("team_id")->nullable()->references("id")->on("teams")->nullOnDelete();

            $table->foreignId("project_image_id")->nullable()->references("id")->on("files")->nullOnDelete();

            $table->string("project_status",20)->nullable()->default("pending");
            $table->string("project_condition",20)->nullable()->default("draft");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
