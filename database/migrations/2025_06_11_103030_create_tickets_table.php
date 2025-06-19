<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi database.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang membuat/membeli tiket
            $table->string('visitor_name'); // Nama pengunjung
            $table->string('visitor_email')->nullable(); // Email pengunjung
            $table->string('ticket_type'); // Contoh: Reguler, VIP, Anak
            $table->decimal('price', 10, 2); // Harga tiket
            $table->integer('quantity'); // Jumlah tiket
            $table->string('qr_code_hash', 36)->unique(); // Tentukan panjang kolom
            $table->enum('status', ['purchased', 'used', 'cancelled'])->default('purchased'); // Status tiket
            $table->timestamps();
        });
    }

    /**
     * Batalkan migrasi database.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
