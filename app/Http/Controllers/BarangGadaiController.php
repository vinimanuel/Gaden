<?php

namespace App\Http\Controllers;

use App\Models\BarangGadai;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BarangGadaiController extends Controller
{
    public function index(Request $request)
    {
        $barang = BarangGadai::filter($request->only(['search', 'status', 'kategori']))
            ->latest('tgl_gadai')
            ->paginate(20)
            ->withQueryString();

        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $kodeGadai = BarangGadai::generateKode();
        return view('barang.create', compact('kodeGadai'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nasabah'        => 'required|string|max:150',
            'ktp'            => 'nullable|string|max:20',
            'no_telp'        => 'nullable|string|max:20',
            'barang'         => 'required|string|max:200',
            'kategori'       => ['required', Rule::in(['Elektronik','Perhiasan','Kendaraan','Lainnya'])],
            'nilai_taksiran' => 'required|integer|min:1',
            'nilai_pinjaman' => 'required|integer|min:1',
            'tgl_gadai'      => 'required|date',
            'bulan_gadai'    => 'required|integer|min:1|max:12',
            'keterangan'     => 'nullable|string|max:500',
        ]);

        $barang = DB::transaction(function () use ($data) {
            $tglGadai   = Carbon::parse($data['tgl_gadai']);
            $jatuhTempo = $tglGadai->copy()->addMonths((int) $data['bulan_gadai']);

            $barang = BarangGadai::create([
                ...$data,
                'kode_gadai'  => BarangGadai::generateKode(),
                'jatuh_tempo' => $jatuhTempo->toDateString(),
                'status'      => 'aktif',
            ]);

            Transaksi::create([
                'tgl_transaksi'   => $barang->tgl_gadai->toDateString(),
                'tipe'            => 'Gadai Baru',
                'barang_gadai_id' => $barang->id,
                'kode_gadai'      => $barang->kode_gadai,
                'nasabah'         => $barang->nasabah,
                'barang'          => $barang->barang,
                'nilai_pinjaman'  => $barang->nilai_pinjaman,
                'biaya'           => 0,
                'keterangan'      => "Masa {$barang->bulan_gadai} bulan · Jatuh tempo "
                    . $jatuhTempo->isoFormat('D MMM YYYY'),
            ]);

            return $barang;
        });

        return redirect()->route('barang.index')
            ->with('success', "Barang gadai {$barang->kode_gadai} berhasil ditambahkan.");
    }

    public function show(BarangGadai $barang)
    {
        $barang->load('transaksi');
        $infoBunga = $barang->status === 'aktif' ? $barang->hitungBungaTebus() : null;
        $infoPerp  = $barang->status === 'aktif' ? $barang->hitungBiayaPerpanjangan() : null;

        return view('barang.show', compact('barang', 'infoBunga', 'infoPerp'));
    }

    public function edit(BarangGadai $barang)
    {
        abort_if($barang->status === 'ditebus', 403, 'Barang sudah ditebus.');
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, BarangGadai $barang)
    {
        abort_if($barang->status === 'ditebus', 403);

        $data = $request->validate([
            'nasabah'        => 'required|string|max:150',
            'ktp'            => 'nullable|string|max:20',
            'no_telp'        => 'nullable|string|max:20',
            'barang'         => 'required|string|max:200',
            'kategori'       => ['required', Rule::in(['Elektronik','Perhiasan','Kendaraan','Lainnya'])],
            'nilai_taksiran' => 'required|integer|min:1',
            'nilai_pinjaman' => 'required|integer|min:1',
            'keterangan'     => 'nullable|string|max:500',
        ]);

        $barang->update($data);

        return redirect()->route('barang.show', $barang)
            ->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(BarangGadai $barang)
    {
        $barang->delete();
        return redirect()->route('barang.index')
            ->with('success', 'Data berhasil dihapus.');
    }

    public function tebusForm(BarangGadai $barang)
    {
        abort_if($barang->status !== 'aktif', 403, 'Barang tidak aktif.');
        $info = $barang->hitungBungaTebus();
        return view('barang.tebus', compact('barang', 'info'));
    }

    public function tebusStore(BarangGadai $barang)
    {
        abort_if($barang->status !== 'aktif', 403);

        $info = $barang->hitungBungaTebus();

        DB::transaction(function () use ($barang, $info) {
            $barang->update(['status' => 'ditebus']);

            Transaksi::create([
                'tgl_transaksi'   => today()->toDateString(),
                'tipe'            => 'Tebus',
                'barang_gadai_id' => $barang->id,
                'kode_gadai'      => $barang->kode_gadai,
                'nasabah'         => $barang->nasabah,
                'barang'          => $barang->barang,
                'nilai_pinjaman'  => $barang->nilai_pinjaman,
                'biaya'           => $info['bunga'],
                'keterangan'      => "Bunga {$info['tipe_bunga']} {$info['persentase']}% (hari ke-{$info['hari_gadai']})",
            ]);
        });

        return redirect()->route('barang.index')
            ->with('success', "Barang {$barang->kode_gadai} berhasil ditebus.");
    }

    public function perpanjangForm(BarangGadai $barang)
    {
        abort_if($barang->status !== 'aktif', 403);
        $info = $barang->hitungBiayaPerpanjangan();
        return view('barang.perpanjang', compact('barang', 'info'));
    }

    public function perpanjangStore(BarangGadai $barang)
    {
        abort_if($barang->status !== 'aktif', 403);

        $info = $barang->hitungBiayaPerpanjangan();

        DB::transaction(function () use ($barang, $info) {
            $bulanBaru = $barang->bulan_gadai + 1;
            $barang->update([
                'jatuh_tempo' => $info['jatuh_tempo_baru'],
                'bulan_gadai' => $bulanBaru,
            ]);

            Transaksi::create([
                'tgl_transaksi'   => today()->toDateString(),
                'tipe'            => 'Perpanjang',
                'barang_gadai_id' => $barang->id,
                'kode_gadai'      => $barang->kode_gadai,
                'nasabah'         => $barang->nasabah,
                'barang'          => $barang->barang,
                'nilai_pinjaman'  => $barang->nilai_pinjaman,
                'biaya'           => $info['biaya'],
                'keterangan'      => "Biaya {$info['persentase']}% flat · Masa gadai jadi {$bulanBaru} bulan",
            ]);
        });

        return redirect()->route('barang.show', $barang)
            ->with('success', "Masa gadai {$barang->kode_gadai} berhasil diperpanjang.");
    }
}
