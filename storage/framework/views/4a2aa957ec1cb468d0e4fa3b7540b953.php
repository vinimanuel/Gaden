<?php $__env->startSection('title', 'Riwayat Transaksi'); ?>

<?php $__env->startSection('content'); ?>

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
        <?php $tc = ['Gadai Baru'=>'b-blue','Perpanjang'=>'b-amber','Tebus'=>'b-green']; ?>
        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td style="font-size:13px;color:var(--text-3);white-space:nowrap">
              <?php echo e($log->tgl_transaksi->isoFormat('D MMM YYYY')); ?>

            </td>
            <td><span class="badge <?php echo e($tc[$log->tipe] ?? 'b-blue'); ?>"><?php echo e($log->tipe); ?></span></td>
            <td>
              <a href="<?php echo e(route('barang.show', $log->barang_gadai_id)); ?>"
                 class="td-id" style="text-decoration:none"><?php echo e($log->kode_gadai); ?></a>
            </td>
            <td class="td-name"><?php echo e($log->nasabah); ?></td>
            <td style="color:var(--text-2)"><?php echo e($log->barang); ?></td>
            <td class="td-money"><?php echo e(rupiah($log->nilai_pinjaman)); ?></td>
            <td style="font-weight:700;color:var(--amber)">
              <?php echo e($log->biaya > 0 ? rupiah($log->biaya) : '—'); ?>

            </td>
            <td style="font-size:13px;color:var(--text-3)"><?php echo e($log->keterangan); ?></td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="8">
              <div class="empty">
                <div class="empty-icon">📜</div>
                <div class="empty-text">Belum ada riwayat transaksi</div>
              </div>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

  <?php if($logs->hasPages()): ?>
    <div class="pagination-wrap"><?php echo e($logs->links()); ?></div>
  <?php endif; ?>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Gadai\resources\views/riwayat/index.blade.php ENDPATH**/ ?>