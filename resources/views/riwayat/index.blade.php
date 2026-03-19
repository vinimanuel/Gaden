@extends('layouts.app')
@section('title', 'Riwayat Transaksi')

@section('content')

<div style="margin-bottom:20px">
  <div style="font-size:22px;font-weight:800">Riwayat Transaksi</div>
  <div style="font-size:14px;color:var(--text-3);margin-top:2px">Catatan semua aktivitas: gadai baru, perpanjangan, dan penebusan</div>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>TANGGAL</th><th>JENIS</th><th>ID GADAI</th><th>NASABAH</th>
          <th>BARANG</th><th>NILAI PINJAMAN</th><th>BIAYA</th><th>KETERANGAN</th>
        </tr>
      </thead>
      <tbody>
        @php $tc = ['Gadai Baru'=>'b-blue','Perpanjang'=>'b-amber','Tebus'=>'b-green']; @endphp
        @forelse($logs as $log)
          <tr>
            <td style="font-size:13px;color:var(--text-3);white-space:nowrap">
              {{ $log->tgl_transaksi->isoFormat('D MMM YYYY') }}
            </td>
            <td><span class="badge {{ $tc[$log->tipe] ?? 'b-blue' }}">{{ $log->tipe }}</span></td>
            <td>
              <a href="{{ route('barang.show', $log->barang_gadai_id) }}"
                 class="td-id" style="text-decoration:none">{{ $log->kode_gadai }}</a>
            </td>
            <td class="td-name">{{ $log->nasabah }}</td>
            <td style="color:var(--text-2)">{{ $log->barang }}</td>
            <td class="td-money">{{ rupiah($log->nilai_pinjaman) }}</td>
            <td style="font-weight:700;color:var(--amber)">
              {{ $log->biaya > 0 ? rupiah($log->biaya) : '—' }}
            </td>
            <td style="font-size:13px;color:var(--text-3)">{{ $log->keterangan }}</td>
          </tr>
        @empty
          <tr>
            <td colspan="8">
              <div class="empty">
                <div class="empty-icon">📜</div>
                <div class="empty-text">Belum ada riwayat transaksi</div>
              </div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($logs->hasPages())
    <div class="pagination-wrap">{{ $logs->links() }}</div>
  @endif
</div>

@endsection
