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
        Schema::create('waste_requests', function (Blueprint $table) {
            $table->id();

            // ------------------ Customer Details ------------------
            // Foreign key linking the request to the submitting user (Normal End User)
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // ------------------ Request Details ------------------
            $table->string('waste_type'); // e.g., 'Household', 'Plastic', 'E-Waste'
            $table->string('quantity')->nullable(); // e.g., 'Small', 'Medium', 'Large'
            $table->text('notes')->nullable();
            $table->timestamp('scheduled_time')->nullable();

            // ------------------ Location Details ------------------
            $table->string('address')->nullable();
            $table->decimal('latitude', 10, 7)->nullable();
            $table->decimal('longitude', 10, 7)->nullable();


            // ------------------ Assignment/Tracking ------------------
            // The Waste Collector User (Field personnel) who is assigned the task <-- NEW FIELD
            $table->foreignId('collector_id')->nullable()->constrained('users')->onDelete('set null');

            // The Waste Authority User (Admin Secondary) who accepted/managed the request
            $table->foreignId('assigned_authority_id')->nullable()->constrained('users')->onDelete('set null');

            // Status of the request: Pending, Accepted, In Progress, Completed, Cancelled
            $table->string('status')->default('Pending'); 
            
            // The time the request was completed
            $table->timestamp('completion_time')->nullable(); 

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waste_requests');
    }
};
