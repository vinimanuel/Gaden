@extends('layouts.app')
@section('title', 'Tambah Barang Gadai')

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
  <div>
    <div style="font-size:22px;font-weight:800">Tambah Barang Gadai</div>
    <div style="font-size:14px;color:var(--text-3);margin-top:2px">Daftarkan barang gadai baru</div>
  </div>
  <a href="{{ route('barang.index') }}" class="btn btn-ghost">← Kembali</a>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">📋 Form Gadai Baru — <span style="color:var(--primary);font-weight:900">{{ $kodeGadai }}</span></div>
  </div>
  <div class="card-body">
    <form method="POST" action="{{ route('barang.store') }}">
      @csrf

      {{-- Data Nasabah --}}
      <div class="form-section">
        <div class="form-section-title">DATA NASABAH</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Nasabah <span style="color:var(--red)">*</span></label>
            <input type="text" name="nasabah" class="form-control" placeholder="Nama lengkap" value="{{ old('nasabah') }}" required>
            @error('nasabah')<div class="form-hint" style="color:var(--red)">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">No. KTP</label>
            <input type="text" name="ktp" class="form-control" placeholder="16 digit NIK" value="{{ old('ktp') }}" maxlength="20">
          </div>
        </div>
        <div class="form-group" style="max-width:50%">
          <label class="form-label">No. Telepon</label>
          <input type="text" name="no_telp" class="form-control" placeholder="628xxxxxxxxxx" value="{{ old('no_telp') }}">
        </div>
      </div>

      {{-- Data Barang --}}
      <div class="form-section">
        <div class="form-section-title">DATA BARANG</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Barang <span style="color:var(--red)">*</span></label>
            <input type="text" name="barang" class="form-control" placeholder="Contoh: iPhone 15 Pro 256GB" value="{{ old('barang') }}" required>
          </div>
          <div class="form-group">
            <label class="form-label">Kategori <span style="color:var(--red)">*</span></label>
            <select name="kategori" class="form-control" required>
              @foreach(['Elektronik','Perhiasan','Kendaraan','Lainnya'] as $k)
                <option value="{{ $k }}" {{ old('kategori') === $k ? 'selected' : '' }}>{{ $k }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nilai Taksiran (Rp) <span style="color:var(--red)">*</span></label>
            <input type="number" name="nilai_taksiran" class="form-control" placeholder="0" value="{{ old('nilai_taksiran') }}" min="1" required>
          </div>
          <div class="form-group">
            <label class="form-label">Nilai Pinjaman (Rp) <span style="color:var(--red)">*</span></label>
            <input type="number" name="nilai_pinjaman" id="nilaiPinjaman" class="form-control" placeholder="0" value="{{ old('nilai_pinjaman') }}" min="1" required>
            <div class="form-hint">Maksimal sama dengan nilai taksiran</div>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Keterangan / Kondisi Barang</label>
          <textarea name="keterangan" class="form-control" placeholder="Kondisi barang, kelengkapan, dll.">{{ old('keterangan') }}</textarea>
        </div>
      </div>

      {{-- Data Gadai --}}
      <div class="form-section">
        <div class="form-section-title">KETENTUAN GADAI</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Tanggal Gadai <span style="color:var(--red)">*</span></label>
            <input type="date" name="tgl_gadai" id="tglGadai" class="form-control" value="{{ old('tgl_gadai', today()->toDateString()) }}" required>
          </div>
          <div class="form-group">
            <label class="form-label">Masa Gadai (bulan) <span style="color:var(--red)">*</span></label>
            <select name="bulan_gadai" id="bulanGadai" class="form-control" required>
              @for($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ old('bulan_gadai', 1) == $i ? 'selected' : '' }}>{{ $i }} Bulan</option>
              @endfor
            </select>
          </div>
        </div>

        {{-- Preview jatuh tempo --}}
        <div style="background:var(--blue-bg);border:1.5px solid var(--blue-border);border-radius:10px;padding:14px 18px;margin-top:4px">
          <div style="font-size:12px;font-weight:700;letter-spacing:1px;color:var(--blue);margin-bottom:8px">PREVIEW JATUH TEMPO</div>
          <div style="font-size:18px;font-weight:800;color:var(--blue)" id="prevJT">—</div>
        </div>
      </div>

      {{-- Preview Bunga --}}
      <div id="prevBunga" style="display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;background:var(--bg);border:1.5px solid var(--border-dark);border-radius:10px;padding:14px">
        <div style="text-align:center;padding:12px;border-radius:9px;background:var(--blue-bg)">
          <div style="font-size:11px;font-weight:600;color:var(--text-3);margin-bottom:4px">BUNGA NORMAL (10%)</div>
          <div style="font-size:15px;font-weight:800;color:var(--blue)" id="pb1">Rp 0</div>
        </div>
        <div style="text-align:center;padding:12px;border-radius:9px;background:var(--green-bg)">
          <div style="font-size:11px;font-weight:600;color:var(--text-3);margin-bottom:4px">BUNGA KHUSUS (5%)</div>
          <div style="font-size:15px;font-weight:800;color:var(--green)" id="pb2">Rp 0</div>
        </div>
        <div style="text-align:center;padding:12px;border-radius:9px;background:var(--amber-bg)">
          <div style="font-size:11px;font-weight:600;color:var(--text-3);margin-bottom:4px">BIAYA PERPANJANG (10%)</div>
          <div style="font-size:15px;font-weight:800;color:var(--amber)" id="pb3">Rp 0</div>
        </div>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end">
        <a href="{{ route('barang.index') }}" class="btn btn-ghost">Batal</a>
        <button type="submit" class="btn btn-primary btn-lg">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
          Simpan Gadai
        </button>
      </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

  function fRp(n) {
    const num = parseInt(n) || 0;
    return 'Rp ' + num.toLocaleString('id-ID');
  }

  function addMonths(dateStr, m) {
    const d = new Date(dateStr);
    d.setMonth(d.getMonth() + parseInt(m));
    return d;
  }

  function updatePreview() {
    const tglEl    = document.getElementById('tglGadai');
    const bulanEl  = document.getElementById('bulanGadai');
    const pinjamEl = document.getElementById('nilaiPinjaman');

    const tgl    = tglEl ? tglEl.value : '';
    const bulan  = bulanEl ? bulanEl.value : '1';
    const pinjam = pinjamEl ? (parseInt(pinjamEl.value) || 0) : 0;

    // Preview jatuh tempo
    const jtEl = document.getElementById('prevJT');
    if (jtEl) {
      if (tgl && bulan) {
        const jt = addMonths(tgl, bulan);
        jtEl.textContent = jt.toLocaleDateString('id-ID', {
          weekday: 'long', day: 'numeric', month: 'long', year: 'numeric'
        });
      } else {
        jtEl.textContent = '—';
      }
    }

    // Preview bunga
    const pb1 = document.getElementById('pb1');
    const pb2 = document.getElementById('pb2');
    const pb3 = document.getElementById('pb3');
    if (pb1) pb1.textContent = fRp(pinjam * 0.10);
    if (pb2) pb2.textContent = fRp(pinjam * 0.05);
    if (pb3) pb3.textContent = fRp(pinjam * 0.10);
  }

  // Pasang listener ke semua field yang mempengaruhi preview
  ['tglGadai', 'bulanGadai', 'nilaiPinjaman'].forEach(function(id) {
    const el = document.getElementById(id);
    if (el) {
      el.addEventListener('input',  updatePreview);
      el.addEventListener('change', updatePreview);
    }
  });

  // Jalankan sekali saat halaman dimuat
  updatePreview();
});
</script>
@endpush
