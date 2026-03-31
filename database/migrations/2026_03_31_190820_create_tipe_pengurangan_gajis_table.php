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
        Schema::create('tipe_pengurangan_gajis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
             $table->boolean('diangsur')->default(0);
            $table->boolean('memotong_kas')->default(0);


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipe_pengurangan_gajis');
    }
};
