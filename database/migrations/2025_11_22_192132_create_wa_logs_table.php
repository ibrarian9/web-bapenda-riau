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
        Schema::create('wa_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('kendaraan_id')->nullable();
            $table->unsignedBigInteger('wajib_pajak_id')->nullable();

            $table->string('nama_wajib_pajak');
            $table->string('nomor_hp');

            $table->text('pesan');

            $table->string('status')->default('pending');

            $table->json('response_api')->nullable();

            $table->timestamps();

            $table->foreign('kendaraan_id')->references('id')->on('kendaraans')->onDelete('set null');
            $table->foreign('wajib_pajak_id')->references('id')->on('wajib_pajaks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wa_logs');
    }
};
