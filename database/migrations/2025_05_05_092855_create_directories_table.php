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
        Schema::create('directories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the directory
            $table->uuid()->unique(); // Unique identifier for the directory
            $table->string('path'); // Path to the directory
            $table->string('disk'); // Storage disk (local, s3, etc.)
            $table->string('visibility')->nullable(); // Visibility (public, private, etc.)
            $table->boolean('locked')->default(false); // Whether the directory is locked or not, by the user(s)
            $table->boolean('protected')->default(false); // Whether the directory is protected or not by the app, for default folders that are created by the app!
            $table->unsignedBigInteger('user_id'); // User who created the directory
            $table->unsignedBigInteger('organization_id')->nullable(); // Organization ID if applicable
            $table->unsignedBigInteger('project_id')->nullable(); // Project ID if applicable
            $table->unsignedBigInteger('parent_id')->nullable(); // Parent directory ID for nested directories
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directories');
    }
};
