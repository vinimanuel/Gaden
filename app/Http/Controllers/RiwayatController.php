<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;

class RiwayatController extends Controller
{
    public function index()
    {
        // Variabel $logs sesuai dengan view riwayat/index.blade.php
        $logs = Transaksi::latest('tgl_transaksi')
            ->latest('id')
            ->paginate(50);

        return view('riwayat.index', compact('logs'));
    }
}
