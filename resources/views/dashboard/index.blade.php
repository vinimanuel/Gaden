@extends('layouts.app')
@section('title', 'Beranda')

@section('content')

{{-- Ringkasan Keseluruhan --}}
<div style="font-size:12px;font-weight:700;letter-spacing:1px;color:var(--text-3);margin-bottom:10px">RINGKASAN KESELURUHAN</div>
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon-wrap si-blue">📦</div>
    <div>
      <div class="stat-label">BARANG AKTIF</div>
      <div class="stat-value blue">{{ $aktif->count() }}</div>
      <div class="stat-sub">sedang digadaikan</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon-wrap si-green">💰</div>
    <div>
      <div class="stat-label">TOTAL PINJAMAN</div>
      <div class="stat-value green">{{ rupiah($aktif->sum('nilai_pinjaman')) }}</div>
      <div class="stat-sub">outstanding</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon-wrap si-green">✅</div>
    <div>
      <div class="stat-label">TOTAL DITEBUS</div>
      <div class="stat-value green">{{ $totalDitebus }}</div>
      <div class="stat-sub">sepanjang waktu</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon-wrap si-amber">⚠️</div>
    <div>
      <div class="stat-label">JATUH TEMPO</div>
      <div class="stat-value amber">{{ $jatuhTempo }}</div>
      <div class="stat-sub">perlu tindakan segera</div>
    </div>
  </div>
</div>

{{-- Aktivitas Hari Ini --}}
<div style="font-size:12px;font-weight:700;letter-spacing:1px;color:var(--text-3);margin-bottom:10px">
  AKTIVITAS HARI INI — <span style="font-weight:600;color:var(--text-2)">{{ now()->isoFormat('dddd, D MMMM YYYY') }}</span>
</div>
<div style="display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-bottom:24px">
  <div class="stat-card" style="border-left:4px solid var(--blue)">
    <div class="stat-icon-wrap si-blue">📋</div>
    <div>
      <div class="stat-label">GADAI BARU HARI INI</div>
      <div class="stat-value blue">{{ $gadaiHariIni }}</div>
      <div class="stat-sub">barang masuk</div>
    </div>
  </div>
  <div class="stat-card" style="border-left:4px solid var(--green)">
    <div class="stat-icon-wrap si-green">💵</div>
    <div>
      <div class="stat-label">DITEBUS HARI INI</div>
      <div class="stat-value green">{{ $tebusHariIni }}</div>
      <div class="stat-sub">transaksi selesai</div>
    </div>
  </div>
  <div class="stat-card" style="border-left:4px solid #D97706">
    <div class="stat-icon-wrap si-amber">🔄</div>
    <div>
      <div class="stat-label">PERPANJANG HARI INI</div>
      <div class="stat-value amber">{{ $perpHariIni }}</div>
      <div class="stat-sub">perpanjangan masa gadai</div>
    </div>
  </div>
</div>

{{-- Tabel Terbaru --}}
<div class="card">
  <div class="card-header">
    <div class="card-title">Barang Gadai Terbaru</div>
    <a href="{{ route('barang.index') }}" class="btn btn-outline btn-sm">Lihat Semua →</a>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID GADAI</th><th>BARANG</th><th>NASABAH</th>
          <th>PINJAMAN</th><th>TGL GADAI</th><th>JATUH TEMPO</th><th>STATUS</th>
        </tr>
      </thead>
      <tbody>
        @forelse($terbaru as $item)
          <tr>
            <td><span class="td-id">{{ $item->kode_gadai }}</span></td>
            <td>
              <div class="td-name">{{ $item->barang }}</div>
              <span class="cat-tag {{ $item->kategori }}">{{ $item->kategori }}</span>
            </td>
            <td>
              <div class="td-name">{{ $item->nasabah }}</div>
              <div class="td-sub">{{ $item->ktp }}</div>
            </td>
            <td><div class="td-money">{{ rupiah($item->nilai_pinjaman) }}</div></td>
            <td style="font-size:13px;color:var(--text-2)">{{ $item->tgl_gadai->isoFormat('D MMM YYYY') }}</td>
            <td style="font-size:13px;color:var(--text-2)">{{ $item->jatuh_tempo->isoFormat('D MMM YYYY') }}</td>
            <td><span class="badge {{ $item->status_class }}"><span class="dot"></span>{{ $item->status_label }}</span></td>
          </tr>
        @empty
          <tr><td colspan="7">
            <div class="empty"><div class="empty-icon">📭</div><div class="empty-text">Belum ada data barang gadai</div></div>
          </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
