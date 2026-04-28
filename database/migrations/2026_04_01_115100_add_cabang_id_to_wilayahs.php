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
        if (Schema::hasTable('wilayahs') && !Schema::hasColumn('wilayahs', 'cabang_id')) {
            Schema::table('wilayahs', function (Blueprint $table) {
                $table->unsignedBigInteger('cabang_id')->after('id')->nullable();

                // optional: foreign key
                $table->foreign('cabang_id')
                      ->references('id')
                      ->on('cabangs')
                      ->cascadeOnDelete();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('wilayahs') && Schema::hasColumn('wilayahs', 'cabang_id')) {
            Schema::table('wilayahs', function (Blueprint $table) {
                // drop foreign dulu baru column
                $table->dropForeign(['cabang_id']);
                $table->dropColumn('cabang_id');
            });
        }
    }
};