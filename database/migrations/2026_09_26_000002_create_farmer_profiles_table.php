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
            $table->foreignId('market_id')->nullable()->constrained('markets')->nullOnDelete();
            $table->string('stall_name', 150);
            $table->string('stall_number', 50)->nullable();
            $table->string('contact_person', 100);
            $table->string('contact_number', 30);
            $table->text('address')->nullable();
            $table->string('operating_days', 100)->default('Saturday, Sunday');
            $table->text('pickup_windows'); // E.g. JSON or comma separated: "08:00 AM - 10:00 AM, 10:00 AM - 12:00 PM, 12:00 PM - 02:00 PM"
            $table->integer('cutoff_hours_before')->default(12); // cut-off hours before market starts
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();
            $table->boolean('is_approved')->default(true); // Admin approval workflow
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('farmer_profiles');
    }
};
