<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Classroom\Enums\Classroom\Cover;
use Modules\Classroom\Enums\Color;
use Modules\Classroom\Enums\Status;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('name');
            $table->text('description')->nullable();

            $table->enum('cover', Cover::values());
            $table->enum('color', Color::values());

            $table->unsignedInteger('fee');

            $table->timestamp('registration_started_at');
            $table->timestamp('registration_ended_at');

            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();

            $table->enum('status', Status::values())->index();

            $table->foreignId('teacher_id')->constrained('teachers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
