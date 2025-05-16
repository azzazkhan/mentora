<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Assignment\Enums\Submission\Status;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->unsignedMediumInteger('grade')->nullable();
            $table->enum('status', Status::values());
            $table->boolean('is_late');
            $table->timestamp('submitted_at')->nullable();

            $table->foreignId('assignment_id')->constrained('assignments');
            $table->foreignId('user_id')->constrained('users');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
