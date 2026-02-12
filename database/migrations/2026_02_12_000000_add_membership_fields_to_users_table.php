<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('points_balance')->default(0)->after('remember_token');
            $table->integer('lifetime_points')->default(0)->after('points_balance');
            $table->string('membership_tier', 20)->default('silver')->after('lifetime_points');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['points_balance', 'lifetime_points', 'membership_tier']);
        });
    }
};
