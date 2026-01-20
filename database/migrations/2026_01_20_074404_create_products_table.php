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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['car', 'tour'])->index();
            $table->text('description')->nullable();
            $table->string('image_url')->nullable();

            // Car-specific fields
            $table->string('car_model')->nullable(); // Toyota Camry
            $table->integer('max_passengers')->nullable();
            $table->integer('max_luggage')->nullable();

            // Tour-specific fields
            $table->string('destination')->nullable(); // Bangkok, Phuket, etc
            $table->string('duration')->nullable(); // 4 Hours, Full Day
            $table->boolean('includes_lunch')->default(false);
            $table->boolean('includes_pickup')->default(false);

            // Pricing
            $table->decimal('base_price', 10, 2);
            $table->decimal('discounted_price', 10, 2)->nullable();
            $table->string('currency', 3)->default('THB');

            // Status & Stats
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('total_reviews')->default(0);
            $table->decimal('average_rating', 3, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
