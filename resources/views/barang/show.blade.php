@extends('layouts.app')
@section('title', $barang->kode_gadai . ' — Detail')

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
  <div>
    <div style="font-size:22px;font-weight:800">{{ $barang->kode_gadai }}</div>
    <div style="font-size:14px;color:var(--text-3);margin-top:2px">Detail barang gadai</div>
  </div>
  <div style="display:flex;gap:8px">
    @if($barang->status === 'aktif')
      <a href="{{ route('barang.edit', $barang) }}" class="btn btn-outline btn-sm">✏️ Edit</a>
      <a href="{{ route('barang.tebus.form', $barang) }}" class="btn btn-green">💵 Proses Tebus</a>
      <a href="{{ route('barang.perpanjang.form', $barang) }}" class="btn btn-amber">🔄 Perpanjang</a>
    @endif
    <a href="{{ route('barang.index') }}" class="btn btn-ghost btn-sm">← Kembali</a>
  </div>
</div>

{{-- Status Banner --}}
<div style="background:{{ $barang->status === 'ditebus' ? 'var(--green-bg)' : ($barang->status_label === 'Jatuh Tempo' ? 'var(--red-bg)' : 'var(--blue-bg)') }};
     border:1.5px solid {{ $barang->status === 'ditebus' ? 'var(--green-border)' : ($barang->status_label === 'Jatuh Tempo' ? 'var(--red-border)' : 'var(--blue-border)') }};
     border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between">
  <div style="font-size:15px;font-weight:700">
    <span class="badge {{ $barang->status_class }}"><span class="dot"></span>{{ $barang->status_label }}</span>
    <span style="margin-left:12px;color:var(--text-2)">{{ $barang->barang }}</span>
  </div>
  @if($barang->status === 'aktif')
    <div style="font-size:14px;font-weight:700;color:var(--text-2)">
      Sisa: <span style="color:{{ $barang->sisa_hari <= 7 ? 'var(--red)' : 'var(--blue)' }};font-size:18px">{{ $barang->sisa_hari }}</span> hari
    </div>
  @endif
</div>

{{-- Info Grid --}}
<div class="detail-info-grid">
  <div class="detail-box">
    <div class="detail-box-title">DATA NASABAH</div>
    <div class="info-row"><span class="info-key">Nama</span><span class="info-val">{{ $barang->nasabah }}</span></div>
    <div class="info-row"><span class="info-key">No. KTP</span><span class="info-val">{{ $barang->ktp ?: '—' }}</span></div>
    <div class="info-row"><span class="info-key">No. Telp</span><span class="info-val">{{ $barang->no_telp ?: '—' }}</span></div>
  </div>
  <div class="detail-box">
    <div class="detail-box-title">DATA BARANG</div>
    <div class="info-row"><span class="info-key">Nama Barang</span><span class="info-val">{{ $barang->barang }}</span></div>
    <div class="info-row"><span class="info-key">Kategori</span><span class="info-val"><span class="cat-tag {{ $barang->kategori }}">{{ $barang->kategori }}</span></span></div>
    <div class="info-row"><span class="info-key">Nilai Taksiran</span><span class="info-val">{{ rupiah($barang->nilai_taksiran) }}</span></div>
    <div class="info-row"><span class="info-key">Nilai Pinjaman</span><span class="info-val" style="color:var(--green)">{{ rupiah($barang->nilai_pinjaman) }}</span></div>
    @if($barang->keterangan)
      <div class="info-row"><span class="info-key">Keterangan</span><span class="info-val" style="font-weight:500;font-size:13px">{{ $barang->keterangan }}</span></div>
    @endif
  </div>
  <div class="detail-box">
    <div class="detail-box-title">KETENTUAN GADAI</div>
    <div class="info-row"><span class="info-key">Tgl Gadai</span><span class="info-val">{{ $barang->tgl_gadai->isoFormat('D MMMM YYYY') }}</span></div>
    <div class="info-row"><span class="info-key">Jatuh Tempo</span><span class="info-val">{{ $barang->jatuh_tempo->isoFormat('D MMMM YYYY') }}</span></div>
    <div class="info-row"><span class="info-key">Masa Gadai</span><span class="info-val">{{ $barang->bulan_gadai }} Bulan</span></div>
  </div>

  @if($barang->status === 'aktif' && $infoBunga)
  <div class="detail-box">
    <div class="detail-box-title">ESTIMASI BIAYA TEBUS SEKARANG</div>
    <div class="info-row">
      <span class="info-key">Hari ke-</span>
      <span class="info-val">{{ $infoBunga['hari_gadai'] }} / {{ $infoBunga['total_hari'] }} hari</span>
    </div>
    <div class="info-row">
      <span class="info-key">Tipe Bunga</span>
      <span class="info-val">
        @if($infoBunga['tipe_bunga'] === 'khusus')
          <span class="badge b-green">⚡ Khusus {{ $infoBunga['persentase'] }}%</span>
        @else
          <span class="badge b-blue">Normal {{ $infoBunga['persentase'] }}%</span>
        @endif
      </span>
    </div>
    <div class="info-row"><span class="info-key">Bunga</span><span class="info-val" style="color:var(--green)">{{ rupiah($infoBunga['bunga']) }}</span></div>
    <div class="info-row"><span class="info-key">Total Bayar</span><span class="info-val" style="color:var(--primary);font-size:16px">{{ rupiah($infoBunga['total_bayar']) }}</span></div>
  </div>
  @endif
</div>

{{-- Riwayat Transaksi --}}
<div class="card">
  <div class="card-header">
    <div class="card-title">Riwayat Transaksi Barang Ini</div>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>TANGGAL</th><th>JENIS</th><th>NILAI PINJAMAN</th><th>BIAYA</th><th>KETERANGAN</th></tr>
      </thead>
      <tbody>
        @php $tc = ['Gadai Baru'=>'b-blue','Perpanjang'=>'b-amber','Tebus'=>'b-green']; @endphp
        @forelse($barang->transaksi->sortByDesc('tgl_transaksi') as $t)
          <tr>
            <td style="font-size:13px;color:var(--text-3)">{{ $t->tgl_transaksi->isoFormat('D MMM YYYY') }}</td>
            <td><span class="badge {{ $tc[$t->tipe] ?? 'b-blue' }}">{{ $t->tipe }}</span></td>
            <td class="td-money">{{ rupiah($t->nilai_pinjaman) }}</td>
            <td style="font-weight:700;color:var(--amber)">{{ $t->biaya > 0 ? rupiah($t->biaya) : '—' }}</td>
            <td style="font-size:13px;color:var(--text-3)">{{ $t->keterangan }}</td>
          </tr>
        @empty
          <tr><td colspan="5"><div class="empty"><div class="empty-icon">📜</div><div class="empty-text">Belum ada transaksi</div></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

{{-- Hapus (soft delete) --}}
@if($barang->status === 'aktif')
<div style="margin-top:20px;padding:16px 20px;background:var(--red-bg);border:1px solid var(--red-border);border-radius:12px;display:flex;justify-content:space-between;align-items:center">
  <div>
    <div style="font-weight:700;color:var(--red)">Zona Berbahaya</div>
    <div style="font-size:13px;color:var(--text-3);margin-top:2px">Hapus data barang ini (dapat dipulihkan)</div>
  </div>
  <form method="POST" action="{{ route('barang.destroy', $barang) }}" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
    @csrf @method('DELETE')
    <button type="submit" class="btn btn-red btn-sm">🗑 Hapus</button>
  </form>
</div>
@endif

@endsection
