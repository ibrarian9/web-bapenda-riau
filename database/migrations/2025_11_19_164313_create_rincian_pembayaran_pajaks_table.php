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
        Schema::create('rincian_pembayaran_pajaks', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('pembayaran_pajak_id')
                  ->constrained('pembayaran_pajaks')
                  ->onDelete('cascade');

            $table->date('jatuh_tempo');
            $table->decimal('pkb', 12, 2)->default(0);
            $table->decimal('swdkllj', 12, 2)->default(0);
            $table->decimal('denda', 12, 2)->default(0);
            $table->decimal('total_bayar', 12, 2)->default(0);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_pembayaran_pajaks');
    }
};
