<?php $__env->startSection('title', 'Edit ' . $barang->kode_gadai); ?>

<?php $__env->startSection('content'); ?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
  <div>
    <div style="font-size:22px;font-weight:800">Edit Barang Gadai</div>
    <div style="font-size:14px;color:var(--text-3);margin-top:2px"><?php echo e($barang->kode_gadai); ?> — <?php echo e($barang->barang); ?></div>
  </div>
  <a href="<?php echo e(route('barang.show', $barang)); ?>" class="btn btn-ghost">← Kembali</a>
</div>

<div class="card">
  <div class="card-body">
    <form method="POST" action="<?php echo e(route('barang.update', $barang)); ?>">
      <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

      <div class="form-section">
        <div class="form-section-title">DATA NASABAH</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Nasabah <span style="color:var(--red)">*</span></label>
            <input type="text" name="nasabah" class="form-control" value="<?php echo e(old('nasabah', $barang->nasabah)); ?>" required>
            <?php $__errorArgs = ['nasabah'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-hint" style="color:var(--red)"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          <div class="form-group">
            <label class="form-label">No. KTP</label>
            <input type="text" name="ktp" class="form-control" value="<?php echo e(old('ktp', $barang->ktp)); ?>" maxlength="20">
          </div>
        </div>
        <div class="form-group" style="max-width:50%">
          <label class="form-label">No. Telepon</label>
          <input type="text" name="no_telp" class="form-control" value="<?php echo e(old('no_telp', $barang->no_telp)); ?>">
        </div>
      </div>

      <div class="form-section">
        <div class="form-section-title">DATA BARANG</div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nama Barang <span style="color:var(--red)">*</span></label>
            <input type="text" name="barang" class="form-control" value="<?php echo e(old('barang', $barang->barang)); ?>" required>
          </div>
          <div class="form-group">
            <label class="form-label">Kategori <span style="color:var(--red)">*</span></label>
            <select name="kategori" class="form-control" required>
              <?php $__currentLoopData = ['Elektronik','Perhiasan','Kendaraan','Lainnya']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($k); ?>" <?php echo e(old('kategori', $barang->kategori) === $k ? 'selected' : ''); ?>><?php echo e($k); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Nilai Taksiran (Rp)</label>
            <input type="number" name="nilai_taksiran" class="form-control" value="<?php echo e(old('nilai_taksiran', $barang->nilai_taksiran)); ?>" min="1" required>
          </div>
          <div class="form-group">
            <label class="form-label">Nilai Pinjaman (Rp)</label>
            <input type="number" name="nilai_pinjaman" class="form-control" value="<?php echo e(old('nilai_pinjaman', $barang->nilai_pinjaman)); ?>" min="1" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Keterangan</label>
          <textarea name="keterangan" class="form-control"><?php echo e(old('keterangan', $barang->keterangan)); ?></textarea>
        </div>
      </div>

      <div style="display:flex;gap:10px;justify-content:flex-end">
        <a href="<?php echo e(route('barang.show', $barang)); ?>" class="btn btn-ghost">Batal</a>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
      </div>
    </form>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Gadai\resources\views/barang/edit.blade.php ENDPATH**/ ?>