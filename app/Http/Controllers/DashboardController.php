<?php

namespace App\Http\Controllers;

use App\Models\BarangGadai;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        // Koleksi barang aktif (dipakai untuk count & sum di view)
        $aktif = BarangGadai::aktif()->get();

        // Statistik keseluruhan
        $totalDitebus = BarangGadai::ditebus()->count();
        $jatuhTempo   = BarangGadai::jatuhTempo()->count();

        // Aktivitas hari ini (dari tabel transaksi)
        $gadaiHariIni = Transaksi::whereDate('tgl_transaksi', today())
                                  ->where('tipe', 'Gadai Baru')->count();
        $tebusHariIni = Transaksi::whereDate('tgl_transaksi', today())
                                  ->where('tipe', 'Tebus')->count();
        $perpHariIni  = Transaksi::whereDate('tgl_transaksi', today())
                                  ->where('tipe', 'Perpanjang')->count();

        // Tabel 8 barang terbaru
        $terbaru = BarangGadai::latest('tgl_gadai')->take(8)->get();

        return view('dashboard.index', compact(
            'aktif',
            'totalDitebus',
            'jatuhTempo',
            'gadaiHariIni',
            'tebusHariIni',
            'perpHariIni',
            'terbaru'
        ));
    }
}
