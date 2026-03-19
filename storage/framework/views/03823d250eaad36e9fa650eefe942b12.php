<?php $__env->startSection('title', 'Barang Gadai'); ?>

<?php $__env->startSection('content'); ?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
  <div>
    <div style="font-size:22px;font-weight:800">Barang Gadai</div>
    <div style="font-size:14px;color:var(--text-3);margin-top:2px">Kelola semua barang yang sedang digadaikan</div>
  </div>
  <a href="<?php echo e(route('barang.create')); ?>" class="btn btn-primary btn-lg">
    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    + Tambah Barang
  </a>
</div>


<form method="GET" action="<?php echo e(route('barang.index')); ?>" class="filter-bar">
  <div class="search-wrap" style="flex:1;min-width:200px">
    <div class="search-icon">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    </div>
    <input class="form-control search-control" name="search" placeholder="Cari nama nasabah, ID, atau barang..."
           value="<?php echo e(request('search')); ?>" style="border-radius:9px">
  </div>
  <select class="form-control" name="status" onchange="this.form.submit()" style="width:175px">
    <option value="">Semua Status</option>
    <option value="aktif"   <?php echo e(request('status') === 'aktif'   ? 'selected' : ''); ?>>Aktif</option>
    <option value="jt"      <?php echo e(request('status') === 'jt'      ? 'selected' : ''); ?>>Jatuh Tempo</option>
    <option value="ditebus" <?php echo e(request('status') === 'ditebus' ? 'selected' : ''); ?>>Sudah Ditebus</option>
  </select>
  <select class="form-control" name="kategori" onchange="this.form.submit()" style="width:165px">
    <option value="">Semua Kategori</option>
    <?php $__currentLoopData = ['Elektronik','Perhiasan','Kendaraan','Lainnya']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($k); ?>" <?php echo e(request('kategori') === $k ? 'selected' : ''); ?>><?php echo e($k); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
  <button type="submit" class="btn btn-primary btn-sm">Cari</button>
  <?php if(request()->hasAny(['search','status','kategori'])): ?>
    <a href="<?php echo e(route('barang.index')); ?>" class="btn btn-ghost btn-sm">Reset</a>
  <?php endif; ?>
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
        <?php $__empty_1 = true; $__currentLoopData = $barang; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td><span class="td-id"><?php echo e($item->kode_gadai); ?></span></td>
            <td>
              <div class="td-name"><?php echo e($item->nasabah); ?></div>
              <div class="td-sub"><?php echo e($item->ktp); ?></div>
            </td>
            <td>
              <div class="td-name"><?php echo e($item->barang); ?></div>
              <span class="cat-tag <?php echo e($item->kategori); ?>"><?php echo e($item->kategori); ?></span>
            </td>
            <td><div class="td-money"><?php echo e(rupiah($item->nilai_pinjaman)); ?></div></td>
            <td style="font-size:13px;color:var(--text-2)"><?php echo e($item->tgl_gadai->isoFormat('D MMM YYYY')); ?></td>
            <td style="font-size:13px;color:var(--text-2)"><?php echo e($item->jatuh_tempo->isoFormat('D MMM YYYY')); ?></td>
            <td>
              <?php $sisa = $item->sisa_hari; ?>
              <?php if($item->status === 'ditebus'): ?>
                <span style="font-size:13px;color:var(--text-3)">—</span>
              <?php elseif($sisa < 0): ?>
                <span style="font-size:13px;font-weight:700;color:var(--red)"><?php echo e(abs($sisa)); ?> hari lalu</span>
              <?php else: ?>
                <span style="font-size:13px;font-weight:700;color:<?php echo e($sisa <= 7 ? 'var(--amber)' : 'var(--text-2)'); ?>"><?php echo e($sisa); ?> hari</span>
              <?php endif; ?>
            </td>
            <td><span class="badge <?php echo e($item->status_class); ?>"><span class="dot"></span><?php echo e($item->status_label); ?></span></td>
            <td>
              <div style="display:flex;gap:6px;flex-wrap:wrap">
                <a href="<?php echo e(route('barang.show', $item)); ?>" class="btn btn-outline btn-sm">Detail</a>
                <?php if($item->status === 'aktif'): ?>
                  <a href="<?php echo e(route('barang.tebus.form', $item)); ?>" class="btn btn-green btn-sm">Tebus</a>
                  <a href="<?php echo e(route('barang.perpanjang.form', $item)); ?>" class="btn btn-amber btn-sm">Perp.</a>
                <?php endif; ?>
              </div>
            </td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="9">
            <div class="empty"><div class="empty-icon">📦</div><div class="empty-text">Belum ada barang gadai</div></div>
          </td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if($barang->hasPages()): ?>
    <div class="pagination-wrap">
      <?php echo e($barang->links()); ?>

    </div>
  <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Gadai\resources\views/barang/index.blade.php ENDPATH**/ ?>