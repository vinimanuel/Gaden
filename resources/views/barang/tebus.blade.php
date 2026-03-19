@extends('layouts.app')
@section('title', 'Proses Tebus — ' . $barang->kode_gadai)

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
  <div>
    <div style="font-size:22px;font-weight:800">💵 Proses Penebusan</div>
    <div style="font-size:14px;color:var(--text-3);margin-top:2px">{{ $barang->kode_gadai }} — {{ $barang->nasabah }}</div>
  </div>
  <a href="{{ route('barang.show', $barang) }}" class="btn btn-ghost">← Kembali</a>
</div>

{{-- Ringkasan Barang --}}
<div class="detail-info-grid" style="margin-bottom:20px">
  <div class="detail-box">
    <div class="detail-box-title">INFO BARANG</div>
    <div class="info-row"><span class="info-key">Barang</span><span class="info-val">{{ $barang->barang }}</span></div>
    <div class="info-row"><span class="info-key">Nasabah</span><span class="info-val">{{ $barang->nasabah }}</span></div>
    <div class="info-row"><span class="info-key">Tgl Gadai</span><span class="info-val">{{ $barang->tgl_gadai->isoFormat('D MMM YYYY') }}</span></div>
    <div class="info-row"><span class="info-key">Jatuh Tempo</span><span class="info-val">{{ $barang->jatuh_tempo->isoFormat('D MMM YYYY') }}</span></div>
  </div>
  <div class="detail-box">
    <div class="detail-box-title">POSISI GADAI</div>
    <div class="info-row"><span class="info-key">Hari ke-</span><span class="info-val">{{ $info['hari_gadai'] }} dari {{ $info['total_hari'] }} hari</span></div>
    <div class="info-row">
      <span class="info-key">Tipe Bunga</span>
      <span class="info-val">
        @if($info['tipe_bunga'] === 'khusus')
          <span class="badge b-green">⚡ Bunga Khusus {{ $info['persentase'] }}%</span>
        @else
          <span class="badge b-blue">Bunga Normal {{ $info['persentase'] }}%</span>
        @endif
      </span>
    </div>
    <div class="info-row">
      <span class="info-key">Syarat Khusus</span>
      <span class="info-val" style="font-size:12px;font-weight:500;color:var(--text-3)">Tebus ≤ {{ intdiv($info['total_hari'], 2) }} hari (≤ ½ masa)</span>
    </div>
  </div>
</div>

{{-- Rincian Biaya --}}
<div class="cost-box" style="margin-bottom:24px">
  <div class="cost-row"><span class="cost-key">Nilai Pinjaman</span><span class="cost-val">{{ rupiah($barang->nilai_pinjaman) }}</span></div>
  <div class="cost-row"><span class="cost-key">Bunga {{ $info['persentase'] }}%</span><span class="cost-val" style="color:var(--green)">+ {{ rupiah($info['bunga']) }}</span></div>
  <div class="cost-row cost-total"><span class="cost-key">Total Bayar</span><span class="cost-val">{{ rupiah($info['total_bayar']) }}</span></div>
</div>

{{-- Konfirmasi --}}
<div style="background:var(--green-bg);border:1.5px solid var(--green-border);border-radius:12px;padding:18px 22px;display:flex;justify-content:space-between;align-items:center">
  <div>
    <div style="font-size:15px;font-weight:800;color:var(--green)">✅ Konfirmasi Penebusan</div>
    <div style="font-size:13px;color:var(--text-2);margin-top:4px">Barang akan berstatus "Ditebus" dan tidak dapat diubah.</div>
  </div>
  <form method="POST" action="{{ route('barang.tebus.store', $barang) }}" onsubmit="return confirm('Konfirmasi proses tebus {{ $barang->kode_gadai }}?')">
    @csrf
    <button type="submit" class="btn btn-green btn-lg">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
      Konfirmasi Tebus
    </button>
  </form>
</div>

@endsection
