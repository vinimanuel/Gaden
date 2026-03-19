<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BarangGadai extends Model
{
    use SoftDeletes;

    protected $table = 'barang_gadai';

    protected $fillable = [
        'kode_gadai',
        'nasabah',
        'ktp',
        'no_telp',
        'barang',
        'kategori',
        'nilai_taksiran',   // ← harus sama persis dengan kolom di migration
        'nilai_pinjaman',
        'tgl_gadai',
        'jatuh_tempo',
        'bulan_gadai',
        'keterangan',
        'status',
    ];

    protected $casts = [
        'tgl_gadai'      => 'date',
        'jatuh_tempo'    => 'date',
        'nilai_taksiran' => 'integer',
        'nilai_pinjaman' => 'integer',
        'bulan_gadai'    => 'integer',
    ];

    // ─── Relationships ───────────────────────────────────────────

    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }

    // ─── Scopes ──────────────────────────────────────────────────

    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    public function scopeDitebus($query)
    {
        return $query->where('status', 'ditebus');
    }

    public function scopeJatuhTempo($query)
    {
        return $query->where('status', 'aktif')
                     ->where('jatuh_tempo', '<', now()->toDateString());
    }

    public function scopeHariIni($query)
    {
        return $query->whereDate('tgl_gadai', today());
    }

    /**
     * Filter dinamis: search, status, kategori.
     */
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, fn($q, $s) =>
            $q->where(fn($q2) => $q2
                ->where('nasabah',     'like', "%{$s}%")
                ->orWhere('kode_gadai','like', "%{$s}%")
                ->orWhere('barang',    'like', "%{$s}%")
            )
        );

        $query->when($filters['status'] ?? null, function ($q, $status) {
            if ($status === 'jt') {
                $q->where('status', 'aktif')
                  ->where('jatuh_tempo', '<', now()->toDateString());
            } else {
                $q->where('status', $status);
            }
        });

        $query->when($filters['kategori'] ?? null, fn($q, $k) => $q->where('kategori', $k));
    }

    // ─── Accessors ───────────────────────────────────────────────

    protected function sisaHari(): Attribute
    {
        return Attribute::get(fn() => (int) now()->diffInDays($this->jatuh_tempo, false));
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(function () {
            if ($this->status === 'ditebus')  return 'Ditebus';
            if ($this->jatuh_tempo->isPast()) return 'Jatuh Tempo';
            if ($this->sisa_hari <= 7)        return 'Hampir JT';
            return 'Aktif';
        });
    }

    protected function statusClass(): Attribute
    {
        return Attribute::get(fn() => match ($this->status_label) {
            'Ditebus'     => 'b-green',
            'Jatuh Tempo' => 'b-red',
            'Hampir JT'   => 'b-amber',
            default       => 'b-blue',
        });
    }

    // ─── Business Logic ──────────────────────────────────────────

    /**
     * Hitung bunga tebus.
     * Tebus ≤ ½ masa gadai  → bunga khusus (5%)
     * Tebus > ½ masa gadai  → bunga normal (10%)
     */
    public function hitungBungaTebus(): array
    {
        $totalHari  = max(1, $this->tgl_gadai->diffInDays($this->jatuh_tempo));
        $hariGadai  = max(0, $this->tgl_gadai->diffInDays(now()));
        $persentase = $hariGadai <= ($totalHari / 2)
            ? config('pegadaian.bunga_khusus', 5)
            : config('pegadaian.bunga_normal', 10);

        $bunga = (int) round($this->nilai_pinjaman * $persentase / 100);

        return [
            'persentase'  => $persentase,
            'bunga'       => $bunga,
            'total_bayar' => $this->nilai_pinjaman + $bunga,
            'hari_gadai'  => $hariGadai,
            'total_hari'  => $totalHari,
            'tipe_bunga'  => $persentase <= config('pegadaian.bunga_khusus', 5) ? 'khusus' : 'normal',
        ];
    }

    /**
     * Hitung biaya perpanjangan: 10% flat dari nilai pinjaman.
     */
    public function hitungBiayaPerpanjangan(): array
    {
        $persentase = config('pegadaian.biaya_perpanjangan', 10);
        $biaya      = (int) round($this->nilai_pinjaman * $persentase / 100);

        return [
            'persentase'       => $persentase,
            'biaya'            => $biaya,
            'jatuh_tempo_baru' => $this->jatuh_tempo->addMonth()->toDateString(),
        ];
    }

    // ─── Static Helpers ──────────────────────────────────────────

    /**
     * Auto-generate kode gadai: GD-001, GD-002, dst.
     */
    public static function generateKode(): string
    {
        $last = static::withTrashed()->orderByDesc('id')->value('kode_gadai');
        $next = $last ? (intval(substr($last, 3)) + 1) : 1;
        return 'GD-' . str_pad($next, 3, '0', STR_PAD_LEFT);
    }
}
