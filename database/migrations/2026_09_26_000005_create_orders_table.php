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
            $table->string('order_number', 50)->unique();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('farmer_id')->constrained('farmer_profiles')->onDelete('cascade');
            $table->foreignId('market_id')->nullable()->constrained('markets')->nullOnDelete();
            $table->decimal('total_amount', 10, 2);
            $table->date('pickup_date');
            $table->string('pickup_time_slot', 100);
            $table->enum('order_status', ['placed', 'accepted', 'ready_for_pickup', 'completed', 'cancelled'])->default('placed');
            $table->string('payment_status', 50)->default('Pay at Pickup (Cash/Card)');
            $table->text('customer_notes')->nullable();
            $table->text('farmer_notes')->nullable();
            $table->timestamp('cutoff_time')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
