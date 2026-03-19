<?php

namespace Database\Seeders;

use App\Models\BarangGadai;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BarangGadaiSeeder extends Seeder
{
    public function run(): void
    {
        $today = today()->toDateString();

        $items = [
            [
                'kode_gadai'     => 'GD-001',
                'nasabah'        => 'Budi Santoso',
                'ktp'            => '3578012345678901',
                'no_telp'        => '6281234567890',
                'barang'         => 'iPhone 15 Pro 256GB',
                'kategori'       => 'Elektronik',
                'nilai_taksiran' => 14000000,
                'nilai_pinjaman' => 9000000,
                'tgl_gadai'      => '2026-03-10',
                'jatuh_tempo'    => '2026-04-09',
                'bulan_gadai'    => 1,
                'keterangan'     => 'Kondisi mulus, box lengkap',
                'status'         => 'aktif',
            ],
            [
                'kode_gadai'     => 'GD-002',
                'nasabah'        => 'Siti Rahayu',
                'ktp'            => '3578098765432109',
                'no_telp'        => '6285678901234',
                'barang'         => 'Gelang Emas 10gr 24K',
                'kategori'       => 'Perhiasan',
                'nilai_taksiran' => 8500000,
                'nilai_pinjaman' => 5000000,
                'tgl_gadai'      => '2026-02-20',
                'jatuh_tempo'    => '2026-04-21',
                'bulan_gadai'    => 2,
                'keterangan'     => 'Cap 24K, berat 10.2gr',
                'status'         => 'aktif',
            ],
            [
                'kode_gadai'     => 'GD-003',
                'nasabah'        => 'Ahmad Fauzi',
                'ktp'            => '3571039912340011',
                'no_telp'        => '6281122334455',
                'barang'         => 'Laptop Dell XPS 15',
                'kategori'       => 'Elektronik',
                'nilai_taksiran' => 18000000,
                'nilai_pinjaman' => 10000000,
                'tgl_gadai'      => '2026-03-01',
                'jatuh_tempo'    => '2026-03-31',
                'bulan_gadai'    => 1,
                'keterangan'     => 'Gen 12, RAM 16GB',
                'status'         => 'ditebus',
            ],
            [
                'kode_gadai'     => 'GD-004',
                'nasabah'        => 'Dewi Kartika',
                'ktp'            => '3578011223344550',
                'no_telp'        => '6281398765432',
                'barang'         => 'Samsung Galaxy S24 Ultra',
                'kategori'       => 'Elektronik',
                'nilai_taksiran' => 16000000,
                'nilai_pinjaman' => 10000000,
                'tgl_gadai'      => $today,
                'jatuh_tempo'    => Carbon::today()->addDays(30)->toDateString(),
                'bulan_gadai'    => 1,
                'keterangan'     => 'Mulus, garansi masih ada',
                'status'         => 'aktif',
            ],
            [
                'kode_gadai'     => 'GD-005',
                'nasabah'        => 'Hendra Wijaya',
                'ktp'            => '3574058876543210',
                'no_telp'        => '6285512345678',
                'barang'         => 'Cincin Emas 22K 5gr',
                'kategori'       => 'Perhiasan',
                'nilai_taksiran' => 4500000,
                'nilai_pinjaman' => 3000000,
                'tgl_gadai'      => $today,
                'jatuh_tempo'    => Carbon::today()->addDays(30)->toDateString(),
                'bulan_gadai'    => 1,
                'keterangan'     => '',
                'status'         => 'aktif',
            ],
        ];

        foreach ($items as $data) {
            $barang = BarangGadai::create($data);

            // Log: Gadai Baru
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
                    . Carbon::parse($barang->jatuh_tempo)->isoFormat('D MMM YYYY'),
            ]);

            // GD-003: tebus hari ini
            if ($barang->kode_gadai === 'GD-003') {
                Transaksi::create([
                    'tgl_transaksi'   => $today,
                    'tipe'            => 'Tebus',
                    'barang_gadai_id' => $barang->id,
                    'kode_gadai'      => $barang->kode_gadai,
                    'nasabah'         => $barang->nasabah,
                    'barang'          => $barang->barang,
                    'nilai_pinjaman'  => $barang->nilai_pinjaman,
                    'biaya'           => 1000000,
                    'keterangan'      => 'Bunga normal 10% (hari ke-13)',
                ]);
            }

            // GD-002: perpanjang hari ini
            if ($barang->kode_gadai === 'GD-002') {
                Transaksi::create([
                    'tgl_transaksi'   => $today,
                    'tipe'            => 'Perpanjang',
                    'barang_gadai_id' => $barang->id,
                    'kode_gadai'      => $barang->kode_gadai,
                    'nasabah'         => $barang->nasabah,
                    'barang'          => $barang->barang,
                    'nilai_pinjaman'  => $barang->nilai_pinjaman,
                    'biaya'           => 500000,
                    'keterangan'      => 'Biaya 10% flat · Masa gadai jadi 3 bulan',
                ]);
            }
        }
    }
}
