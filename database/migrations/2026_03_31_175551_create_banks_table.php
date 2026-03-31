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
        Schema::create('banks', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('nomor_rekening')->nullable();
        $table->integer('potongan_transaksi')->default(0);
        $table->boolean('tampilkan_di_kasir')->default(true);
        $table->boolean('rekening_global')->default(false);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banks');
    }
};
