<?php $__env->startSection('title', 'Rincian Keuangan'); ?>

<?php $__env->startSection('content'); ?>

<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px">
  <div>
    <div style="font-size:22px;font-weight:800">Rincian Keuangan</div>
    <div style="font-size:14px;color:var(--text-3);margin-top:2px">Rekap pemasukan dari bunga & biaya perpanjangan</div>
  </div>
  <form method="GET" action="<?php echo e(route('keuangan.index')); ?>">
    <select name="periode" class="form-control" onchange="this.form.submit()" style="width:160px">
      <option value="semua" <?php echo e($periode === 'semua' ? 'selected' : ''); ?>>Semua Waktu</option>
      <option value="hari"  <?php echo e($periode === 'hari'  ? 'selected' : ''); ?>>Hari Ini</option>
      <option value="minggu"<?php echo e($periode === 'minggu'? 'selected' : ''); ?>>7 Hari Terakhir</option>
      <option value="bulan" <?php echo e($periode === 'bulan' ? 'selected' : ''); ?>>Bulan Ini</option>
    </select>
  </form>
</div>


<div class="stats-grid" style="margin-bottom:20px">
  <div class="stat-card">
    <div class="stat-icon-wrap si-blue">💵</div>
    <div>
      <div class="stat-label">TOTAL PINJAMAN DISALURKAN</div>
      <div class="stat-value blue"><?php echo e(rupiah($totalPinjaman)); ?></div>
      <div class="stat-sub">dari semua gadai</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon-wrap si-green">📈</div>
    <div>
      <div class="stat-label">PENDAPATAN BUNGA</div>
      <div class="stat-value green"><?php echo e(rupiah($totalBunga)); ?></div>
      <div class="stat-sub"><?php echo e($logs->where('tipe','Tebus')->count()); ?> penebusan</div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon-wrap si-amber">🔄</div>
    <div>
      <div class="stat-label">PENDAPATAN PERPANJANGAN</div>
      <div class="stat-value amber"><?php echo e(rupiah($totalPerp)); ?></div>
      <div class="stat-sub"><?php echo e($logs->where('tipe','Perpanjang')->count()); ?> perpanjangan</div>
    </div>
  </div>
  <div class="stat-card" style="border-left:4px solid var(--green)">
    <div class="stat-icon-wrap si-green">🏦</div>
    <div>
      <div class="stat-label">TOTAL PENDAPATAN</div>
      <div class="stat-value green"><?php echo e(rupiah($totalPendapatan)); ?></div>
      <div class="stat-sub">bunga + perpanjangan</div>
    </div>
  </div>
</div>


<div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px;margin-bottom:24px">
  <div class="card">
    <div class="card-body" style="padding:16px 20px">
      <div style="font-size:12px;font-weight:700;letter-spacing:1px;color:var(--text-3);margin-bottom:8px">POTENSI BUNGA (AKTIF)</div>
      <div style="font-size:11px;color:var(--text-3);margin-bottom:10px">Jika semua barang aktif ditebus normal (10%)</div>
      <div style="font-size:22px;font-weight:800;color:var(--blue)"><?php echo e(rupiah($potensiNormal)); ?></div>
      <div style="margin-top:6px;font-size:11px;color:var(--text-3)">Jika ditebus bunga khusus (5%)</div>
      <div style="font-size:18px;font-weight:700;color:var(--green);margin-top:3px"><?php echo e(rupiah($potensiKhusus)); ?></div>
    </div>
  </div>
  <div class="card">
    <div class="card-body" style="padding:16px 20px">
      <div style="font-size:12px;font-weight:700;letter-spacing:1px;color:var(--text-3);margin-bottom:8px">POTENSI PERPANJANGAN</div>
      <div style="font-size:11px;color:var(--text-3);margin-bottom:10px">Jika semua barang aktif diperpanjang 1×</div>
      <div style="font-size:22px;font-weight:800;color:var(--amber)"><?php echo e(rupiah($potensiPerp)); ?></div>
    </div>
  </div>
  <div class="card">
    <div class="card-body" style="padding:16px 20px">
      <div style="font-size:12px;font-weight:700;letter-spacing:1px;color:var(--text-3);margin-bottom:8px">NILAI OUTSTANDING</div>
      <div style="font-size:11px;color:var(--text-3);margin-bottom:10px">Total pinjaman yang belum ditebus</div>
      <div style="font-size:22px;font-weight:800;color:var(--red)"><?php echo e(rupiah($outstanding)); ?></div>
      <div style="margin-top:6px;font-size:11px;color:var(--text-3)"><?php echo e($aktif->count()); ?> barang aktif</div>
    </div>
  </div>
</div>


<div class="card">
  <div class="card-header">
    <div class="card-title">Rincian Transaksi Pendapatan</div>
    <div style="font-size:13px;color:var(--text-3)"><?php echo e($logs->count()); ?> transaksi</div>
  </div>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>TANGGAL</th><th>JENIS</th><th>ID GADAI</th><th>NASABAH</th>
          <th>BARANG</th><th>NILAI PINJAMAN</th><th>PENDAPATAN</th><th>KETERANGAN</th>
        </tr>
      </thead>
      <tbody>
        <?php $tc = ['Tebus'=>'b-green','Perpanjang'=>'b-amber']; ?>
        <?php $__empty_1 = true; $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <tr>
            <td style="font-size:13px;color:var(--text-3);white-space:nowrap"><?php echo e($log->tgl_transaksi->isoFormat('D MMM YYYY')); ?></td>
            <td><span class="badge <?php echo e($tc[$log->tipe] ?? 'b-blue'); ?>"><?php echo e($log->tipe); ?></span></td>
            <td><a href="<?php echo e(route('barang.show', $log->barang_gadai_id)); ?>" class="td-id" style="text-decoration:none"><?php echo e($log->kode_gadai); ?></a></td>
            <td class="td-name"><?php echo e($log->nasabah); ?></td>
            <td style="color:var(--text-2)"><?php echo e($log->barang); ?></td>
            <td class="td-money"><?php echo e(rupiah($log->nilai_pinjaman)); ?></td>
            <td>
              <span style="font-size:15px;font-weight:800;color:<?php echo e($log->tipe==='Tebus' ? 'var(--green)' : 'var(--amber)'); ?>">
                + <?php echo e(rupiah($log->biaya)); ?>

              </span>
            </td>
            <td style="font-size:13px;color:var(--text-3)"><?php echo e($log->keterangan); ?></td>
          </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <tr>
            <td colspan="8">
              <div class="empty">
                <div class="empty-icon">💰</div>
                <div class="empty-text">Belum ada transaksi pada periode ini</div>
              </div>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
      <?php if($logs->count()): ?>
        <tfoot>
          <tr style="background:var(--primary)">
            <td colspan="6" style="padding:13px 18px;font-size:15px;font-weight:700;color:rgba(255,255,255,0.85)">Total Pendapatan</td>
            <td style="padding:13px 18px;font-size:20px;font-weight:800;color:#fff"><?php echo e(rupiah($totalPendapatan)); ?></td>
            <td></td>
          </tr>
        </tfoot>
      <?php endif; ?>
    </table>
  </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Gadai\resources\views/keuangan/index.blade.php ENDPATH**/ ?>