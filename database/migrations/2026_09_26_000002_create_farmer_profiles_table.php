<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('farmer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('market_id')->nullable()->constrained('markets')->onDelete('set null');
            $table->string('stall_name');
            $table->text('bio')->nullable();
            $table->string('operating_days')->nullable();
            $table->string('pickup_time_start')->default('08:00');
            $table->string('pickup_time_end')->default('14:00');
            $table->integer('order_cutoff_hours')->default(3); // Cut-off time before pickup
            $table->string('stall_number')->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->string('status')->default('pending'); // pending, approved, suspended
            $table->string('banner_image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farmer_profiles');
    }
};
