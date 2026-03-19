@extends('layouts.app')
@section('title', 'Edit ' . $barang->kode_gadai)

@section('content')

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
  <div>
    <div style="font-size:22px;font-weight:800">Edit Barang Gadai</div>
    <div style="font-size:14px;color:var(--text-3);margin-top:2px">{{ $barang->kode_gadai }} — {{ $barang->barang }}</div>
  </div>
  <a href="{{ route('barang.show', $barang) }}" class="btn btn-ghost">← Kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST" action="{{ route('barang.update', $barang) }}">
      @csrf @method('PUT')

      <div class="form-section">
        <div class="form-section-title">DATA NASABAH</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Nasabah <span style="color:var(--red)">*</span></label>
            <input type="text" name="nasabah" class="form-control" value="{{ old('nasabah', $barang->nasabah) }}" required>
            @error('nasabah')<div class="form-hint" style="color:var(--red)">{{ $message }}</div>@enderror
          </div>
          <div class="form-group">
            <label class="form-label">No. KTP</label>
            <input type="text" name="ktp" class="form-control" value="{{ old('ktp', $barang->ktp) }}" maxlength="20">
          </div>
        </div>
        <div class="form-group" style="max-width:50%">
          <label class="form-label">No. Telepon</label>
          <input type="text" name="no_telp" class="form-control" value="{{ old('no_telp', $barang->no_telp) }}">
        </div>
      </div>

      <div class="form-section">
        <div class="form-section-title">DATA BARANG</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Barang <span style="color:var(--red)">*</span></label>
            <input type="text" name="barang" class="form-control" value="{{ old('barang', $barang->barang) }}" required>
          </div>
          <div class="form-group">
            <label class="form-label">Kategori <span style="color:var(--red)">*</span></label>
            <select name="kategori" class="form-control" required>
              @foreach(['Elektronik','Perhiasan','Kendaraan','Lainnya'] as $k)
                <option value="{{ $k }}" {{ old('kategori', $barang->kategori) === $k ? 'selected' : '' }}>{{ $k }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nilai Taksiran (Rp)</label>
            <input type="number" name="nilai_taksiran" class="form-control" value="{{ old('nilai_taksiran', $barang->nilai_taksiran) }}" min="1" required>
          </div>
          <div class="form-group">
            <label class="form-label">Nilai Pinjaman (Rp)</label>
            <input type="number" name="nilai_pinjaman" class="form-control" value="{{ old('nilai_pinjaman', $barang->nilai_pinjaman) }}" min="1" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Keterangan</label>
          <textarea name="keterangan" class="form-control">{{ old('keterangan', $barang->keterangan) }}</textarea>
        </div>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end">
        <a href="{{ route('barang.show', $barang) }}" class="btn btn-ghost">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

@endsection
