<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = [
        'tgl_transaksi', 'tipe', 'barang_gadai_id',
        'kode_gadai', 'nasabah', 'barang',
        'nilai_pinjaman', 'biaya', 'keterangan',
    ];

    protected $casts = [
        'tgl_transaksi'  => 'date',
        'nilai_pinjaman' => 'integer',
        'biaya'          => 'integer',
    ];

    // ── Relationships ─────────────────────────────────────────
    public function barangGadai(): BelongsTo
    {
        return $this->belongsTo(BarangGadai::class, 'barang_gadai_id');
    }

    // ── Scopes ────────────────────────────────────────────────
    public function scopePendapatan($query)
    {
        return $query->whereIn('tipe', ['Tebus', 'Perpanjang']);
    }

    public function scopePeriode($query, string $periode)
    {
        return match ($periode) {
            'hari'   => $query->whereDate('tgl_transaksi', today()),
            'minggu' => $query->where('tgl_transaksi', '>=', now()->subDays(6)->startOfDay()),
            'bulan'  => $query->whereMonth('tgl_transaksi', now()->month)
                              ->whereYear('tgl_transaksi', now()->year),
            default  => $query,
        };
    }

    public function scopeHariIni($query)
    {
        return $query->whereDate('tgl_transaksi', today());
    }
}
