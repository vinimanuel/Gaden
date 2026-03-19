<?php $__env->startSection('title', 'Proses Tebus — ' . $barang->kode_gadai); ?>

<?php $__env->startSection('content'); ?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
  <div>
    <div style="font-size:22px;font-weight:800">💵 Proses Penebusan</div>
    <div style="font-size:14px;color:var(--text-3);margin-top:2px"><?php echo e($barang->kode_gadai); ?> — <?php echo e($barang->nasabah); ?></div>
  </div>
  <a href="<?php echo e(route('barang.show', $barang)); ?>" class="btn btn-ghost">← Kembali</a>
</div>


<div class="detail-info-grid" style="margin-bottom:20px">
  <div class="detail-box">
    <div class="detail-box-title">INFO BARANG</div>
    <div class="info-row"><span class="info-key">Barang</span><span class="info-val"><?php echo e($barang->barang); ?></span></div>
    <div class="info-row"><span class="info-key">Nasabah</span><span class="info-val"><?php echo e($barang->nasabah); ?></span></div>
    <div class="info-row"><span class="info-key">Tgl Gadai</span><span class="info-val"><?php echo e($barang->tgl_gadai->isoFormat('D MMM YYYY')); ?></span></div>
    <div class="info-row"><span class="info-key">Jatuh Tempo</span><span class="info-val"><?php echo e($barang->jatuh_tempo->isoFormat('D MMM YYYY')); ?></span></div>
  </div>
  <div class="detail-box">
    <div class="detail-box-title">POSISI GADAI</div>
    <div class="info-row"><span class="info-key">Hari ke-</span><span class="info-val"><?php echo e($info['hari_gadai']); ?> dari <?php echo e($info['total_hari']); ?> hari</span></div>
    <div class="info-row">
      <span class="info-key">Tipe Bunga</span>
      <span class="info-val">
        <?php if($info['tipe_bunga'] === 'khusus'): ?>
          <span class="badge b-green">⚡ Bunga Khusus <?php echo e($info['persentase']); ?>%</span>
        <?php else: ?>
          <span class="badge b-blue">Bunga Normal <?php echo e($info['persentase']); ?>%</span>
        <?php endif; ?>
      </span>
    </div>
    <div class="info-row">
      <span class="info-key">Syarat Khusus</span>
      <span class="info-val" style="font-size:12px;font-weight:500;color:var(--text-3)">Tebus ≤ <?php echo e(intdiv($info['total_hari'], 2)); ?> hari (≤ ½ masa)</span>
    </div>
  </div>
</div>


<div class="cost-box" style="margin-bottom:24px">
  <div class="cost-row"><span class="cost-key">Nilai Pinjaman</span><span class="cost-val"><?php echo e(rupiah($barang->nilai_pinjaman)); ?></span></div>
  <div class="cost-row"><span class="cost-key">Bunga <?php echo e($info['persentase']); ?>%</span><span class="cost-val" style="color:var(--green)">+ <?php echo e(rupiah($info['bunga'])); ?></span></div>
  <div class="cost-row cost-total"><span class="cost-key">Total Bayar</span><span class="cost-val"><?php echo e(rupiah($info['total_bayar'])); ?></span></div>
</div>


<div style="background:var(--green-bg);border:1.5px solid var(--green-border);border-radius:12px;padding:18px 22px;display:flex;justify-content:space-between;align-items:center">
  <div>
    <div style="font-size:15px;font-weight:800;color:var(--green)">✅ Konfirmasi Penebusan</div>
    <div style="font-size:13px;color:var(--text-2);margin-top:4px">Barang akan berstatus "Ditebus" dan tidak dapat diubah.</div>
  </div>
  <form method="POST" action="<?php echo e(route('barang.tebus.store', $barang)); ?>" onsubmit="return confirm('Konfirmasi proses tebus <?php echo e($barang->kode_gadai); ?>?')">
    <?php echo csrf_field(); ?>
    <button type="submit" class="btn btn-green btn-lg">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
      Konfirmasi Tebus
    </button>
  </form>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Gadai\resources\views/barang/tebus.blade.php ENDPATH**/ ?>