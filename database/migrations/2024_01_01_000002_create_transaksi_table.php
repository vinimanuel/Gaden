<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->date('tgl_transaksi');
            $table->enum('tipe', ['Gadai Baru', 'Perpanjang', 'Tebus']);
            $table->foreignId('barang_gadai_id')
                  ->constrained('barang_gadai')
                  ->cascadeOnDelete();
            $table->string('kode_gadai', 20);
            $table->string('nasabah', 150);
            $table->string('barang', 200);
            $table->unsignedBigInteger('nilai_pinjaman');
            $table->unsignedBigInteger('biaya')->default(0);
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->index('tgl_transaksi');
            $table->index('tipe');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
