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
        Schema::create('organization_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->boolean('is_active')->default(true); // If the user is active in the organization, if false, he doesn't have access to the organization
            $table->timestamp('joined_at')->nullable(); // Date when the user joined the organization
            $table->timestamp('last_active')->nullable(); // Date when the user was last active in the organization
            $table->timestamps();
            $table->unique(['organization_id', 'user_id']); // Unique constraint to prevent duplicate entries
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organization_user');
    }
};
