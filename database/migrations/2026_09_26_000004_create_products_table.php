<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('farmer_id')->constrained('farmer_profiles')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            $table->string('name', 150);
            $table->string('slug', 150);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('unit', 50)->default('kg'); // kg, bunch, dozen, lb, box, jar
            $table->integer('stock_quantity')->default(0);
            $table->boolean('is_sold_out')->default(false);
            $table->boolean('is_weekly_template')->default(false);
            $table->string('harvest_date')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
