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
        Schema::create('cabangs', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('kode')->unique();
            $table->string('wilayah')->nullable();
            $table->string('telpon')->nullable();
            $table->string('hp')->nullable();
            $table->text('alamat')->nullable();
            $table->integer('tanggal_tutup_buku')->default(1);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cabangs');
    }
};
