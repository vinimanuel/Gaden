@extends('layouts.app')
@section('title', 'Barang Gadai')

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
  <div>
    <div style="font-size:22px;font-weight:800">Barang Gadai</div>
    <div style="font-size:14px;color:var(--text-3);margin-top:2px">Kelola semua barang yang sedang digadaikan</div>
  </div>
  <a href="{{ route('barang.create') }}" class="btn btn-primary btn-lg">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    + Tambah Barang
  </a>
</div>

{{-- Filter Bar --}}
<form method="GET" action="{{ route('barang.index') }}" class="filter-bar">
  <div class="search-wrap" style="flex:1;min-width:200px">
    <div class="search-icon">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    </div>
    <input class="form-control search-control" name="search" placeholder="Cari nama nasabah, ID, atau barang..."
           value="{{ request('search') }}" style="border-radius:9px">
  </div>
  <select class="form-control" name="status" onchange="this.form.submit()" style="width:175px">
    <option value="">Semua Status</option>
    <option value="aktif"   {{ request('status') === 'aktif'   ? 'selected' : '' }}>Aktif</option>
    <option value="jt"      {{ request('status') === 'jt'      ? 'selected' : '' }}>Jatuh Tempo</option>
    <option value="ditebus" {{ request('status') === 'ditebus' ? 'selected' : '' }}>Sudah Ditebus</option>
  </select>
  <select class="form-control" name="kategori" onchange="this.form.submit()" style="width:165px">
    <option value="">Semua Kategori</option>
    @foreach(['Elektronik','Perhiasan','Kendaraan','Lainnya'] as $k)
      <option value="{{ $k }}" {{ request('kategori') === $k ? 'selected' : '' }}>{{ $k }}</option>
    @endforeach
  </select>
  <button type="submit" class="btn btn-primary btn-sm">Cari</button>
  @if(request()->hasAny(['search','status','kategori']))
    <a href="{{ route('barang.index') }}" class="btn btn-ghost btn-sm">Reset</a>
  @endif
</form>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>ID GADAI</th><th>NASABAH</th><th>BARANG & KATEGORI</th>
          <th>NILAI PINJAMAN</th><th>TGL GADAI</th><th>JATUH TEMPO</th>
          <th>SISA HARI</th><th>STATUS</th><th>TINDAKAN</th>
        </tr>
      </thead>
      <tbody>
        @forelse($barang as $item)
          <tr>
            <td><span class="td-id">{{ $item->kode_gadai }}</span></td>
            <td>
              <div class="td-name">{{ $item->nasabah }}</div>
              <div class="td-sub">{{ $item->ktp }}</div>
            </td>
            <td>
              <div class="td-name">{{ $item->barang }}</div>
              <span class="cat-tag {{ $item->kategori }}">{{ $item->kategori }}</span>
            </td>
            <td><div class="td-money">{{ rupiah($item->nilai_pinjaman) }}</div></td>
            <td style="font-size:13px;color:var(--text-2)">{{ $item->tgl_gadai->isoFormat('D MMM YYYY') }}</td>
            <td style="font-size:13px;color:var(--text-2)">{{ $item->jatuh_tempo->isoFormat('D MMM YYYY') }}</td>
            <td>
              @php $sisa = $item->sisa_hari; @endphp
              @if($item->status === 'ditebus')
                <span style="font-size:13px;color:var(--text-3)">—</span>
              @elseif($sisa < 0)
                <span style="font-size:13px;font-weight:700;color:var(--red)">{{ abs($sisa) }} hari lalu</span>
              @else
                <span style="font-size:13px;font-weight:700;color:{{ $sisa <= 7 ? 'var(--amber)' : 'var(--text-2)' }}">{{ $sisa }} hari</span>
              @endif
            </td>
            <td><span class="badge {{ $item->status_class }}"><span class="dot"></span>{{ $item->status_label }}</span></td>
            <td>
              <div style="display:flex;gap:6px;flex-wrap:wrap">
                <a href="{{ route('barang.show', $item) }}" class="btn btn-outline btn-sm">Detail</a>
                @if($item->status === 'aktif')
                  <a href="{{ route('barang.tebus.form', $item) }}" class="btn btn-green btn-sm">Tebus</a>
                  <a href="{{ route('barang.perpanjang.form', $item) }}" class="btn btn-amber btn-sm">Perp.</a>
                @endif
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="9">
            <div class="empty"><div class="empty-icon">📦</div><div class="empty-text">Belum ada barang gadai</div></div>
          </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($barang->hasPages())
    <div class="pagination-wrap">
      {{ $barang->links() }}
    </div>
  @endif
</div>

@endsection
