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
        Schema::create('pembayaran_iurans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('penghuni_rumah_id');
            $table->foreign('penghuni_rumah_id')->references('id')->on('penghuni_rumahs')->onDelete('cascade');
            $table->unsignedBigInteger('iuran_id');
            $table->foreign('iuran_id')->references('id')->on('iurans')->onDelete('cascade');
            $table->integer('bulan'); // 1-12
            $table->integer('tahun');
            $table->decimal('jumlah', 10, 2)->nullable();
            $table->enum('status', ['lunas', 'belum lunas'])->default('belum lunas');
            $table->date('tanggal_bayar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran_iurans');
    }
};
