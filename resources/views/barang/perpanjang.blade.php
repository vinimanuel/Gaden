@extends('layouts.app')
@section('title', 'Perpanjang — ' . $barang->kode_gadai)

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
  <div>
    <div style="font-size:22px;font-weight:800">🔄 Perpanjang Masa Gadai</div>
    <div style="font-size:14px;color:var(--text-3);margin-top:2px">{{ $barang->kode_gadai }} — {{ $barang->nasabah }}</div>
  </div>
  <a href="{{ route('barang.show', $barang) }}" class="btn btn-ghost">← Kembali</a>
</div>

<div class="detail-info-grid" style="margin-bottom:20px">
  <div class="detail-box">
    <div class="detail-box-title">INFO BARANG</div>
    <div class="info-row"><span class="info-key">Barang</span><span class="info-val">{{ $barang->barang }}</span></div>
    <div class="info-row"><span class="info-key">Nasabah</span><span class="info-val">{{ $barang->nasabah }}</span></div>
    <div class="info-row"><span class="info-key">Masa Gadai Saat Ini</span><span class="info-val">{{ $barang->bulan_gadai }} Bulan</span></div>
    <div class="info-row"><span class="info-key">Jatuh Tempo Lama</span><span class="info-val">{{ $barang->jatuh_tempo->isoFormat('D MMM YYYY') }}</span></div>
  </div>
  <div class="detail-box">
    <div class="detail-box-title">SETELAH PERPANJANGAN</div>
    <div class="info-row"><span class="info-key">Masa Gadai Baru</span><span class="info-val" style="color:var(--blue)">{{ $barang->bulan_gadai + 1 }} Bulan</span></div>
    <div class="info-row">
      <span class="info-key">Jatuh Tempo Baru</span>
      <span class="info-val" style="color:var(--blue)">
        {{ \Carbon\Carbon::parse($info['jatuh_tempo_baru'])->isoFormat('D MMMM YYYY') }}
      </span>
    </div>
  </div>
</div>

{{-- Rincian Biaya --}}
<div class="cost-box" style="margin-bottom:24px">
  <div class="cost-row"><span class="cost-key">Nilai Pinjaman</span><span class="cost-val">{{ rupiah($barang->nilai_pinjaman) }}</span></div>
  <div class="cost-row"><span class="cost-key">Biaya Perpanjangan {{ $info['persentase'] }}% flat</span><span class="cost-val" style="color:var(--amber)">+ {{ rupiah($info['biaya']) }}</span></div>
  <div class="cost-row cost-total"><span class="cost-key">Total Biaya yang Dibayar</span><span class="cost-val">{{ rupiah($info['biaya']) }}</span></div>
</div>

<div style="background:var(--amber-bg);border:1.5px solid var(--amber-border);border-radius:12px;padding:18px 22px;display:flex;justify-content:space-between;align-items:center">
  <div>
    <div style="font-size:15px;font-weight:800;color:var(--amber)">🔄 Konfirmasi Perpanjangan</div>
    <div style="font-size:13px;color:var(--text-2);margin-top:4px">Jatuh tempo akan diperpanjang +1 bulan.</div>
  </div>
  <form method="POST" action="{{ route('barang.perpanjang.store', $barang) }}" onsubmit="return confirm('Konfirmasi perpanjang masa gadai {{ $barang->kode_gadai }}?')">
    @csrf
    <button type="submit" class="btn btn-amber btn-lg">Konfirmasi Perpanjang</button>
  </form>
</div>

@endsection
