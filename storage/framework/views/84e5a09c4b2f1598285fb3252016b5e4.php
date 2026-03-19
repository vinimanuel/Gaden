<?php $__env->startSection('title', $barang->kode_gadai . ' — Detail'); ?>

<?php $__env->startSection('content'); ?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
  <div>
    <div style="font-size:22px;font-weight:800"><?php echo e($barang->kode_gadai); ?></div>
    <div style="font-size:14px;color:var(--text-3);margin-top:2px">Detail barang gadai</div>
  </div>
  <div style="display:flex;gap:8px">
    <?php if($barang->status === 'aktif'): ?>
      <a href="<?php echo e(route('barang.edit', $barang)); ?>" class="btn btn-outline btn-sm">✏️ Edit</a>
      <a href="<?php echo e(route('barang.tebus.form', $barang)); ?>" class="btn btn-green">💵 Proses Tebus</a>
      <a href="<?php echo e(route('barang.perpanjang.form', $barang)); ?>" class="btn btn-amber">🔄 Perpanjang</a>
    <?php endif; ?>
    <a href="<?php echo e(route('barang.index')); ?>" class="btn btn-ghost btn-sm">← Kembali</a>
  </div>
</div>


<div style="background:<?php echo e($barang->status === 'ditebus' ? 'var(--green-bg)' : ($barang->status_label === 'Jatuh Tempo' ? 'var(--red-bg)' : 'var(--blue-bg)')); ?>;
     border:1.5px solid <?php echo e($barang->status === 'ditebus' ? 'var(--green-border)' : ($barang->status_label === 'Jatuh Tempo' ? 'var(--red-border)' : 'var(--blue-border)')); ?>;
     border-radius:12px;padding:14px 18px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between">
  <div style="font-size:15px;font-weight:700">
    <span class="badge <?php echo e($barang->status_class); ?>"><span class="dot"></span><?php echo e($barang->status_label); ?></span>
    <span style="margin-left:12px;color:var(--text-2)"><?php echo e($barang->barang); ?></span>
  </div>
  <?php if($barang->status === 'aktif'): ?>
    <div style="font-size:14px;font-weight:700;color:var(--text-2)">
      Sisa: <span style="color:<?php echo e($barang->sisa_hari <= 7 ? 'var(--red)' : 'var(--blue)'); ?>;font-size:18px"><?php echo e($barang->sisa_hari); ?></span> hari
    </div>
  <?php endif; ?>
</div>


<div class="detail-info-grid">
  <div class="detail-box">
    <div class="detail-box-title">DATA NASABAH</div>
    <div class="info-row"><span class="info-key">Nama</span><span class="info-val"><?php echo e($barang->nasabah); ?></span></div>
    <div class="info-row"><span class="info-key">No. KTP</span><span class="info-val"><?php echo e($barang->ktp ?: '—'); ?></span></div>
    <div class="info-row"><span class="info-key">No. Telp</span><span class="info-val"><?php echo e($barang->no_telp ?: '—'); ?></span></div>
  </div>
  <div class="detail-box">
    <div class="detail-box-title">DATA BARANG</div>
    <div class="info-row"><span class="info-key">Nama Barang</span><span class="info-val"><?php echo e($barang->barang); ?></span></div>
    <div class="info-row"><span class="info-key">Kategori</span><span class="info-val"><span class="cat-tag <?php echo e($barang->kategori); ?>"><?php echo e($barang->kategori); ?></span></span></div>
    <div class="info-row"><span class="info-key">Nilai Taksiran</span><span class="info-val"><?php echo e(rupiah($barang->nilai_taksiran)); ?></span></div>
    <div class="info-row"><span class="info-key">Nilai Pinjaman</span><span class="info-val" style="color:var(--green)"><?php echo e(rupiah($barang->nilai_pinjaman)); ?></span></div>
    <?php if($barang->keterangan): ?>
      <div class="info-row"><span class="info-key">Keterangan</span><span class="info-val" style="font-weight:500;font-size:13px"><?php echo e($barang->keterangan); ?></span></div>
    <?php endif; ?>
  </div>
  <div class="detail-box">
    <div class="detail-box-title">KETENTUAN GADAI</div>
    <div class="info-row"><span class="info-key">Tgl Gadai</span><span class="info-val"><?php echo e($barang->tgl_gadai->isoFormat('D MMMM YYYY')); ?></span></div>
    <div class="info-row"><span class="info-key">Jatuh Tempo</span><span class="info-val"><?php echo e($barang->jatuh_tempo->isoFormat('D MMMM YYYY')); ?></span></div>
    <div class="info-row"><span class="info-key">Masa Gadai</span><span class="info-val"><?php echo e($barang->bulan_gadai); ?> Bulan</span></div>
  </div>

  <?php if($barang->status === 'aktif' && $infoBunga): ?>
  <div class="detail-box">
    <div class="detail-box-title">ESTIMASI BIAYA TEBUS SEKARANG</div>
    <div class="info-row">
      <span class="info-key">Hari ke-</span>
      <span class="info-val"><?php echo e($infoBunga['hari_gadai']); ?> / <?php echo e($infoBunga['total_hari']); ?> hari</span>
    </div>
    <div class="info-row">
      <span class="info-key">Tipe Bunga</span>
      <span class="info-val">
        <?php if($infoBunga['tipe_bunga'] === 'khusus'): ?>
          <span class="badge b-green">⚡ Khusus <?php echo e($infoBunga['persentase']); ?>%</span>
        <?php else: ?>
          <span class="badge b-blue">Normal <?php echo e($infoBunga['persentase']); ?>%</span>
        <?php endif; ?>
      </span>
    </div>
    <div class="info-row"><span class="info-key">Bunga</span><span class="info-val" style="color:var(--green)"><?php echo e(rupiah($infoBunga['bunga'])); ?></span></div>
    <div class="info-row"><span class="info-key">Total Bayar</span><span class="info-val" style="color:var(--primary);font-size:16px"><?php echo e(rupiah($infoBunga['total_bayar'])); ?></span></div>
  </div>
  <?php endif; ?>
</div>


<div class="card">
  <div class="card-header">
    <div class="card-title">Riwayat Transaksi Barang Ini</div>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>TANGGAL</th><th>JENIS</th><th>NILAI PINJAMAN</th><th>BIAYA</th><th>KETERANGAN</th></tr>
      </thead>
      <tbody>
        <?php $tc = ['Gadai Baru'=>'b-blue','Perpanjang'=>'b-amber','Tebus'=>'b-green']; ?>
        <?php $__empty_1 = true; $__currentLoopData = $barang->transaksi->sortByDesc('tgl_transaksi'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td style="font-size:13px;color:var(--text-3)"><?php echo e($t->tgl_transaksi->isoFormat('D MMM YYYY')); ?></td>
            <td><span class="badge <?php echo e($tc[$t->tipe] ?? 'b-blue'); ?>"><?php echo e($t->tipe); ?></span></td>
            <td class="td-money"><?php echo e(rupiah($t->nilai_pinjaman)); ?></td>
            <td style="font-weight:700;color:var(--amber)"><?php echo e($t->biaya > 0 ? rupiah($t->biaya) : '—'); ?></td>
            <td style="font-size:13px;color:var(--text-3)"><?php echo e($t->keterangan); ?></td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr><td colspan="5"><div class="empty"><div class="empty-icon">📜</div><div class="empty-text">Belum ada transaksi</div></div></td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>


<?php if($barang->status === 'aktif'): ?>
<div style="margin-top:20px;padding:16px 20px;background:var(--red-bg);border:1px solid var(--red-border);border-radius:12px;display:flex;justify-content:space-between;align-items:center">
  <div>
    <div style="font-weight:700;color:var(--red)">Zona Berbahaya</div>
    <div style="font-size:13px;color:var(--text-3);margin-top:2px">Hapus data barang ini (dapat dipulihkan)</div>
  </div>
  <form method="POST" action="<?php echo e(route('barang.destroy', $barang)); ?>" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
    <button type="submit" class="btn btn-red btn-sm">🗑 Hapus</button>
  </form>
</div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Gadai\resources\views/barang/show.blade.php ENDPATH**/ ?>