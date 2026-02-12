<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('car_service_type', 40)->nullable()->after('service_type');
            $table->unsignedSmallInteger('charter_hours')->nullable()->after('flight_number');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['car_service_type', 'charter_hours']);
        });
    }
};
