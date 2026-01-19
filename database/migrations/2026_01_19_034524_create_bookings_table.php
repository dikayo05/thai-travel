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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            // Identitas Booking
            $table->string('booking_code')->unique(); // Contoh: BK-20260119-XYZ
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // Nullable agar Guest bisa order

            // Detail Kontak Tamu (Snapshot data saat booking)
            // Penting jika User mengupdate profil, data di booking lama tidak berubah
            $table->string('guest_name');
            $table->string('guest_email');
            $table->string('guest_phone')->nullable();

            // Detail Layanan
            $table->enum('service_type', ['car', 'tour']); // Pembeda layanan
            $table->unsignedBigInteger('product_id')->nullable(); // ID Mobil atau ID Tur
            $table->string('product_name'); // Snapshot nama produk (misal: "Toyota Camry" atau "Bangkok Temple Tour")

            // Waktu & Logistik
            $table->date('service_date');
            $table->time('service_time')->nullable(); // Jam penjemputan
            $table->string('pickup_location')->nullable();
            $table->string('dropoff_location')->nullable();
            $table->string('flight_number')->nullable(); // Khusus Airport Transfer

            // Kuantitas
            $table->integer('quantity')->default(1); // Jumlah mobil atau jumlah peserta tur
            $table->integer('adult_pax')->nullable(); // Detail pax tur
            $table->integer('child_pax')->nullable(); // Detail pax tur

            // Keuangan
            $table->decimal('total_price', 15, 2); // Menggunakan decimal untuk uang
            $table->string('currency', 3)->default('THB');

            // Status & Catatan
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->enum('payment_status', ['unpaid', 'paid', 'refunded'])->default('unpaid');
            $table->text('special_request')->nullable(); // Catatan dari customer
            $table->text('admin_notes')->nullable(); // Catatan internal admin/ops
            $table->softDeletes(); // Agar data keuangan tidak hilang permanen
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
