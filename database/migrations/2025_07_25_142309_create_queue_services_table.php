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
        Schema::create('queue_services', function (Blueprint $table) {
            $table->id();
            $table->string('queue_number')->index();
            $table->enum('type_queue', ['reservation', 'walkin']);
            $table->string('patient_name');
            $table->string('phone');
            $table->timestamp('registration_time');
            $table->enum('status', ['waiting', 'called', 'done']);
            $table->foreignId('staff_id')->nullable()->constrained('staff')->onDelete('cascade');
            $table->string('locket_counter')->nullable();
            $table->timestamp('time_called')->nullable();
            $table->timestamp('time_end')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_services');
    }
};
