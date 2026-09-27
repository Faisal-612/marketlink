<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('farmer_id')->constrained('users')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->date('pickup_date');
            $table->string('pickup_time_slot');
            $table->string('order_status')->default('placed'); // placed, accepted, ready_for_pickup, completed, cancelled
            $table->string('payment_status')->default('pay_at_pickup_pending'); // pay_at_pickup_pending, paid_at_pickup
            $table->text('customer_notes')->nullable();
            $table->text('farmer_notes')->nullable();
            $table->text('cancelled_reason')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
