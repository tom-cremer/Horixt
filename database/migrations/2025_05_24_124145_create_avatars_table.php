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
        Schema::create('avatars', function (Blueprint $table) {
            $table->id();
            $table->string('path');
            $table->string('name');
            $table->string('extension');
            $table->string('mime_type');
            $table->integer('size'); // Size in bytes
            $table->string('disk'); // Storage disk (local, s3, etc.)
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('organization_id')->nullable(); // Organization ID if applicable
            $table->timestamps();

            $table->unique(['user_id', 'organization_id']); // Pour éviter un doublon
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avatars');
    }
};
