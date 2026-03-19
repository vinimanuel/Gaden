<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_gadai', function (Blueprint $table) {
            $table->id();
            $table->string('kode_gadai', 20)->unique();
            $table->string('nasabah', 150);
            $table->string('ktp', 20)->nullable();
            $table->string('no_telp', 20)->nullable();
            $table->string('barang', 200);
            $table->enum('kategori', ['Elektronik', 'Perhiasan', 'Kendaraan', 'Lainnya'])->default('Elektronik');
            $table->unsignedBigInteger('nilai_taksiran');
            $table->unsignedBigInteger('nilai_pinjaman');
            $table->date('tgl_gadai');
            $table->date('jatuh_tempo');
            $table->unsignedTinyInteger('bulan_gadai')->default(1);
            $table->text('keterangan')->nullable();
            $table->enum('status', ['aktif', 'ditebus', 'jatuh_tempo'])->default('aktif');
            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('tgl_gadai');
            $table->index('jatuh_tempo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_gadai');
    }
};
