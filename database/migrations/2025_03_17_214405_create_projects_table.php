<?php

use App\Enums\ProjectPriority;
use App\Enums\ProjectStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('status')->default(ProjectStatus::PENDING->value);
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Mode solo
            /*$table->foreignId('organisation_id')->nullable()->constrained()->onDelete('cascade'); // Mode organisation*/
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('priority')->default(ProjectPriority::LOW->value);
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
