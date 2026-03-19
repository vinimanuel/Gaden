@extends('layouts.app')
@section('title', '403 — Akses Ditolak')

@section('content')
<div style="text-align:center;padding:80px 24px">
  <div style="font-size:72px;margin-bottom:16px">🔒</div>
  <div style="font-size:32px;font-weight:800;color:var(--text);margin-bottom:8px">Akses Ditolak</div>
  <div style="font-size:16px;color:var(--text-3);margin-bottom:32px;max-width:400px;margin-left:auto;margin-right:auto">
    Anda tidak memiliki izin untuk mengakses halaman ini.
    Role Anda: <strong>{{ auth()->user()->role_label ?? '—' }}</strong>
  </div>
  <div style="display:flex;gap:12px;justify-content:center">
    <a href="{{ route('dashboard') }}" class="btn btn-primary">← Kembali ke Beranda</a>
    <a href="javascript:history.back()" class="btn btn-ghost">Halaman Sebelumnya</a>
  </div>
</div>
@endsection
