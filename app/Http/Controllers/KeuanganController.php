<?php

namespace App\Http\Controllers;

use App\Models\BarangGadai;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        $periode = $request->get('periode', 'semua');

        // Pendapatan (Tebus + Perpanjang) — variabel $logs sesuai dengan view
        $logs = Transaksi::pendapatan()
            ->periode($periode)
            ->latest('tgl_transaksi')
            ->latest('id')
            ->get();

        $totalBunga      = $logs->where('tipe', 'Tebus')->sum('biaya');
        $totalPerp       = $logs->where('tipe', 'Perpanjang')->sum('biaya');
        $totalPendapatan = $totalBunga + $totalPerp;

        // Agregat keseluruhan
        $totalPinjaman = BarangGadai::sum('nilai_pinjaman');
        $aktif         = BarangGadai::aktif()->get();
        $outstanding   = $aktif->sum('nilai_pinjaman');

        // Potensi — sebagai variabel terpisah sesuai view
        $potensiNormal = (int) round($outstanding * config('pegadaian.bunga_normal', 10) / 100);
        $potensiKhusus = (int) round($outstanding * config('pegadaian.bunga_khusus', 5)  / 100);
        $potensiPerp   = (int) round($outstanding * config('pegadaian.biaya_perpanjangan', 10) / 100);

        return view('keuangan.index', compact(
            'logs',
            'periode',
            'totalBunga',
            'totalPerp',
            'totalPendapatan',
            'totalPinjaman',
            'outstanding',
            'aktif',
            'potensiNormal',
            'potensiKhusus',
            'potensiPerp'
        ));
    }
}
