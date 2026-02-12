<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->decimal('subtotal_price', 15, 2)->default(0)->after('child_pax');
            $table->decimal('discount_amount', 15, 2)->default(0)->after('subtotal_price');
            $table->foreignId('coupon_id')->nullable()->after('discount_amount')->constrained()->nullOnDelete();
            $table->string('coupon_code')->nullable()->after('coupon_id');
            $table->integer('points_earned')->default(0)->after('coupon_code');
            $table->timestamp('reviewed_at')->nullable()->after('points_earned');
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['subtotal_price', 'discount_amount', 'coupon_code', 'points_earned', 'reviewed_at']);
            $table->dropConstrainedForeignId('coupon_id');
        });
    }
};
