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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('cabang')->nullable();
        $table->string('nama');
        $table->string('nik')->nullable();
        $table->string('tempat_lahir')->nullable();
        $table->date('tanggal_lahir')->nullable();
        $table->text('alamat')->nullable();
        $table->string('hp')->nullable();
        $table->string('jenis_kelamin')->nullable();
        $table->boolean('menikah')->default(false);
        $table->integer('jumlah_anak')->default(0);
        $table->string('pendidikan')->nullable();
        $table->string('penyakit')->nullable();
        $table->string('nomor_darurat')->nullable();
        $table->string('jabatan')->nullable();
        $table->date('bergabung_pada')->nullable();
        $table->boolean('is_terapis')->default(false);
        $table->boolean('is_active')->default(true);
        $table->decimal('gaji_pokok', 15, 2)->default(0);
        $table->integer('komisi')->default(0);
        $table->string('email')->nullable();
        $table->string('password')->nullable();
        $table->string('role')->nullable();
        $table->string('foto')->nullable();





            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
