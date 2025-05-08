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
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the file
            $table->string('alt')->nullable(); // Alt text for the file
            $table->string('path'); // Path to the file
            $table->integer('size'); // Size in bytes
            $table->string('extension'); // File extension
            $table->string('disk'); // Storage disk (local, s3, etc.)
            $table->string('mime_type'); // MIME type of the file
            $table->string('visibility'); // Visibility (public, private, etc.)
            $table->string('checksum')->nullable();
            $table->boolean('locked')->default(false); // Whether the file is locked or not, by the user(s)
            $table->unsignedBigInteger('user_id'); // User who uploaded the file
            $table->unsignedBigInteger('organization_id')->nullable(); // Organization ID if applicable
            $table->unsignedBigInteger('project_id')->nullable(); // Project ID if applicable
            $table->unsignedBigInteger('directory_id')->nullable(); // Folder ID if applicable
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
