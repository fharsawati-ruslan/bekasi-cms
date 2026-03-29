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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kode_transaksi')->nullable();
            $table->dateTime('waktu')->nullable();
            $table->string('nama_tamu')->nullable();

            $table->foreignId('cabang_id')->nullable();
            $table->foreignId('kasir_id')->nullable();
            $table->foreignId('kamar_id')->nullable();
            $table->foreignId('member_id')->nullable();
            $table->foreignId('terapis_id')->nullable();

            $table->string('status')->nullable();
            $table->string('pembayaran')->nullable();
            $table->string('voucher')->nullable();

            $table->decimal('harga', 12, 2)->default(0);
            $table->decimal('biaya', 12, 2)->default(0);
            $table->decimal('profit', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
