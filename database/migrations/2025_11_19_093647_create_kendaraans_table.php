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
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('wajib_pajak_id')->constrained()->cascadeOnDelete();

            $table->string('nopol')->unique();
            $table->string('merek');
            $table->string('tipe');
            $table->integer('tahun_pembuatan');
            $table->string('warna');
            $table->string('nomor_mesin');
            $table->string('nomor_rangka');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
