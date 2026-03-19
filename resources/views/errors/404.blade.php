@extends('layouts.app')
@section('title', '404 — Halaman Tidak Ditemukan')

@section('content')
<div style="text-align:center;padding:80px 24px">
  <div style="font-size:72px;margin-bottom:16px">🔍</div>
  <div style="font-size:32px;font-weight:800;color:var(--text);margin-bottom:8px">Halaman Tidak Ditemukan</div>
  <div style="font-size:16px;color:var(--text-3);margin-bottom:32px">
    Halaman yang Anda cari tidak ada atau sudah dipindahkan.
  </div>
  <a href="{{ route('dashboard') }}" class="btn btn-primary">← Kembali ke Beranda</a>
</div>
@endsection
