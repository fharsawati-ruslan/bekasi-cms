<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('nama');

            $table->foreignId('satuan_dasar_id')->constrained('satuans');
            $table->foreignId('satuan_konversi_id')->constrained('satuans');

            $table->integer('qty_konversi')->default(1);

            $table->decimal('harga_jual_dasar', 15, 2)->default(0);
            $table->decimal('harga_jual_konversi', 15, 2)->default(0);

            $table->boolean('is_inventory')->default(false);
            $table->boolean('is_sellable')->default(false);

            $table->integer('urutan')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};