<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>@yield('title', 'Beranda') — Pegadaian Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
:root{--bg:#F5F6FA;--white:#FFFFFF;--sidebar:#1B3A6B;--sidebar-text:rgba(255,255,255,0.75);--primary:#1B3A6B;--primary-light:#2E5BA8;--green:#1A7F4B;--green-bg:#E8F5EE;--green-border:#A8D9BB;--amber:#B45309;--amber-bg:#FEF3C7;--amber-border:#FCD34D;--red:#B91C1C;--red-bg:#FEE2E2;--red-border:#FCA5A5;--blue:#1E40AF;--blue-bg:#DBEAFE;--blue-border:#93C5FD;--text:#111827;--text-2:#374151;--text-3:#6B7280;--border:#E5E7EB;--border-dark:#D1D5DB;--shadow:0 1px 4px rgba(0,0,0,.08),0 4px 16px rgba(0,0,0,.05);--shadow-lg:0 8px 32px rgba(0,0,0,.12);--radius:14px;--radius-sm:9px}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;font-size:15px;line-height:1.5}
/* SIDEBAR */
.sidebar{position:fixed;left:0;top:0;bottom:0;width:230px;background:var(--sidebar);display:flex;flex-direction:column;z-index:100;box-shadow:2px 0 12px rgba(0,0,0,.15)}
.sidebar-logo{padding:24px 20px 20px;border-bottom:1px solid rgba(255,255,255,.1)}
.logo-icon{width:42px;height:42px;border-radius:12px;background:#fff;display:grid;place-items:center;margin-bottom:10px;box-shadow:0 2px 8px rgba(0,0,0,.2)}
.logo-icon svg{width:24px;height:24px}
.logo-name{font-size:17px;font-weight:800;color:#fff;letter-spacing:-.3px}
.logo-sub{font-size:11px;color:var(--sidebar-text);margin-top:2px}
.nav-group{padding:16px 12px 0;flex:1}
.nav-label{font-size:10px;font-weight:700;letter-spacing:1.5px;color:rgba(255,255,255,.4);padding:0 8px 8px}
.nav-item{display:flex;align-items:center;gap:11px;padding:12px 14px;border-radius:10px;font-size:14px;font-weight:600;color:var(--sidebar-text);transition:all .2s;margin-bottom:3px;text-decoration:none}
.nav-item:hover{background:rgba(255,255,255,.1);color:#fff}
.nav-item.active{background:#fff;color:var(--primary);box-shadow:0 2px 8px rgba(0,0,0,.15)}
.nav-icon{width:20px;height:20px;flex-shrink:0}
.sidebar-policy{margin:0 12px 12px;padding:14px;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.12);border-radius:12px}
.sp-title{font-size:9px;font-weight:700;letter-spacing:2px;color:rgba(255,255,255,.4);margin-bottom:10px}
.sp-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px}
.sp-row:last-child{margin-bottom:0}
.sp-key{font-size:12px;color:rgba(255,255,255,.65)}
.sp-val{font-size:13px;font-weight:700}
.sp-val.g{color:#6EE7B7}.sp-val.w{color:#FCD34D}.sp-val.b{color:#93C5FD}
.sp-sep{height:1px;background:rgba(255,255,255,.1);margin:8px 0}
.sidebar-bottom{padding:12px;border-top:1px solid rgba(255,255,255,.1)}
.user-chip{display:flex;align-items:center;gap:10px;padding:10px 12px;border-radius:10px;background:rgba(255,255,255,.08)}
.user-avatar{width:34px;height:34px;border-radius:9px;background:#fff;display:grid;place-items:center;font-size:13px;font-weight:800;color:var(--primary);flex-shrink:0}
.user-name{font-size:13px;font-weight:700;color:#fff}
.user-role{font-size:11px;color:rgba(255,255,255,.5)}
/* MAIN */
.main{margin-left:230px;min-height:100vh}
.topbar{background:var(--white);border-bottom:1px solid var(--border);padding:0 28px;height:64px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0;z-index:50;box-shadow:0 1px 4px rgba(0,0,0,.06)}
.page-title{font-size:20px;font-weight:800;color:var(--text)}
.clock-badge{background:var(--bg);border:1px solid var(--border);border-radius:8px;padding:6px 12px;font-size:14px;font-weight:700;color:var(--text-2);letter-spacing:.5px}
.content{padding:28px}
/* CARDS */
.card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);box-shadow:var(--shadow);overflow:hidden}
.card-header{padding:18px 22px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
.card-title{font-size:15px;font-weight:800;color:var(--text)}
.card-body{padding:20px 22px}
/* STATS */
.stats-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:24px}
.stat-card{background:var(--white);border:1px solid var(--border);border-radius:var(--radius);padding:20px 22px;box-shadow:var(--shadow);display:flex;align-items:center;gap:16px;transition:box-shadow .2s,transform .2s}
.stat-card:hover{box-shadow:var(--shadow-lg);transform:translateY(-2px)}
.stat-icon-wrap{width:52px;height:52px;border-radius:14px;display:grid;place-items:center;font-size:22px;flex-shrink:0}
.si-blue{background:var(--blue-bg)}.si-green{background:var(--green-bg)}.si-amber{background:var(--amber-bg)}.si-red{background:var(--red-bg)}
.stat-label{font-size:12px;font-weight:600;color:var(--text-3);margin-bottom:4px;letter-spacing:.3px}
.stat-value{font-size:24px;font-weight:800;color:var(--text);line-height:1.1}
.stat-value.blue{color:var(--blue)}.stat-value.green{color:var(--green)}.stat-value.amber{color:var(--amber)}.stat-value.red{color:var(--red)}
.stat-sub{font-size:11px;color:var(--text-3);margin-top:2px}
/* BUTTONS */
.btn{padding:10px 20px;border-radius:9px;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;cursor:pointer;border:none;display:inline-flex;align-items:center;gap:8px;transition:all .2s;text-decoration:none}
.btn-primary{background:var(--primary);color:#fff;box-shadow:0 2px 8px rgba(27,58,107,.25)}
.btn-primary:hover{background:var(--primary-light);transform:translateY(-1px)}
.btn-outline{background:var(--white);color:var(--primary);border:2px solid var(--primary)}
.btn-outline:hover{background:var(--blue-bg)}
.btn-green{background:var(--green);color:#fff}.btn-green:hover{background:#166038;transform:translateY(-1px)}
.btn-amber{background:#D97706;color:#fff}.btn-amber:hover{background:var(--amber);transform:translateY(-1px)}
.btn-red{background:var(--red);color:#fff}.btn-red:hover{background:#991B1B;transform:translateY(-1px)}
.btn-ghost{background:transparent;color:var(--text-2);border:1.5px solid var(--border-dark)}.btn-ghost:hover{background:var(--bg)}
.btn-sm{padding:7px 14px;font-size:13px;border-radius:7px}
.btn-lg{padding:14px 28px;font-size:16px;border-radius:11px}
/* BADGE */
.badge{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:700}
.b-green{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border)}
.b-amber{background:var(--amber-bg);color:var(--amber);border:1px solid var(--amber-border)}
.b-red{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border)}
.b-blue{background:var(--blue-bg);color:var(--blue);border:1px solid var(--blue-border)}
.b-gray{background:#F3F4F6;color:var(--text-3);border:1px solid var(--border-dark)}
.dot{width:6px;height:6px;border-radius:50%;background:currentColor}
/* TABLE */
.table-wrap{overflow-x:auto}
table{width:100%;border-collapse:collapse}
thead th{padding:12px 16px;text-align:left;font-size:11px;font-weight:700;letter-spacing:1px;color:var(--text-3);background:#F9FAFB;border-bottom:2px solid var(--border);white-space:nowrap}
tbody tr{border-bottom:1px solid var(--border);transition:background .15s}
tbody tr:hover{background:#F9FAFB}
tbody tr:last-child{border-bottom:none}
tbody td{padding:14px 16px;font-size:14px;vertical-align:middle}
.td-id{font-weight:800;color:var(--primary);font-size:13px}
.td-name{font-weight:700;color:var(--text)}
.td-sub{font-size:12px;color:var(--text-3);margin-top:2px}
.td-money{font-size:14px;font-weight:800;color:var(--text)}
.cat-tag{display:inline-block;padding:3px 9px;border-radius:5px;font-size:12px;font-weight:700;background:var(--blue-bg);color:var(--blue);border:1px solid var(--blue-border)}
.cat-tag.Perhiasan{background:var(--amber-bg);color:var(--amber);border-color:var(--amber-border)}
.cat-tag.Kendaraan{background:var(--green-bg);color:var(--green);border-color:var(--green-border)}
.cat-tag.Lainnya{background:#F3F4F6;color:var(--text-3);border-color:var(--border-dark)}
/* FORM */
.form-section{margin-bottom:20px}
.form-section-title{font-size:12px;font-weight:700;letter-spacing:1px;color:var(--text-3);margin-bottom:12px;padding-bottom:8px;border-bottom:1px solid var(--border)}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.form-row-3{display:grid;grid-template-columns:1fr 1fr 1fr;gap:14px}
.form-group{margin-bottom:14px}
.form-label{display:block;font-size:13px;font-weight:700;color:var(--text-2);margin-bottom:7px}
.form-control{width:100%;padding:12px 14px;border:2px solid var(--border-dark);border-radius:9px;font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;color:var(--text);background:var(--white);outline:none;transition:border-color .2s,box-shadow .2s}
.form-control:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(27,58,107,.1)}
.form-control::placeholder{color:#9CA3AF}
select.form-control{cursor:pointer}
textarea.form-control{resize:vertical;min-height:76px}
.form-hint{font-size:12px;color:var(--text-3);margin-top:5px}
/* FILTER BAR */
.filter-bar{display:flex;gap:12px;flex-wrap:wrap;align-items:center;padding:16px 20px;background:var(--white);border:1px solid var(--border);border-radius:var(--radius);margin-bottom:14px;box-shadow:var(--shadow)}
/* MODAL */
.modal-overlay{position:fixed;inset:0;z-index:200;background:rgba(17,24,39,.55);backdrop-filter:blur(4px);display:none;align-items:center;justify-content:center;padding:20px}
.modal-overlay.open{display:flex;animation:fi .2s}
@keyframes fi{from{opacity:0}to{opacity:1}}
.modal{background:var(--white);border-radius:18px;width:100%;max-width:600px;box-shadow:0 20px 60px rgba(0,0,0,.2);animation:su .25s ease;max-height:92vh;overflow-y:auto}
.modal-lg{max-width:700px}
@keyframes su{from{transform:translateY(16px);opacity:0}to{transform:translateY(0);opacity:1}}
.modal-header{padding:22px 26px 18px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;background:var(--white);position:sticky;top:0;z-index:2}
.modal-title{font-size:18px;font-weight:800;color:var(--text)}
.modal-close{width:36px;height:36px;border-radius:9px;border:2px solid var(--border-dark);background:var(--white);cursor:pointer;display:grid;place-items:center;font-size:16px;color:var(--text-3);font-weight:700;transition:all .2s}
.modal-close:hover{background:var(--red-bg);border-color:var(--red-border);color:var(--red)}
.modal-body{padding:24px 26px}
.modal-footer{padding:16px 26px;border-top:1px solid var(--border);display:flex;justify-content:flex-end;gap:10px;background:#F9FAFB}
/* DETAIL */
.detail-info-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px}
.detail-box{background:#F9FAFB;border:1px solid var(--border);border-radius:12px;padding:16px}
.detail-box-title{font-size:11px;font-weight:700;letter-spacing:1px;color:var(--text-3);margin-bottom:12px}
.info-row{display:flex;justify-content:space-between;align-items:flex-start;padding:8px 0;border-bottom:1px solid var(--border);gap:12px}
.info-row:last-child{border-bottom:none}
.info-key{font-size:13px;color:var(--text-3);flex-shrink:0}
.info-val{font-size:14px;font-weight:700;color:var(--text);text-align:right}
/* COST BOX */
.cost-box{background:#F9FAFB;border:1px solid var(--border);border-radius:12px;overflow:hidden;margin-bottom:16px}
.cost-row{display:flex;justify-content:space-between;align-items:center;padding:13px 18px;border-bottom:1px solid var(--border)}
.cost-row:last-child{border-bottom:none}
.cost-key{font-size:14px;color:var(--text-2)}
.cost-val{font-size:15px;font-weight:800}
.cost-total{background:var(--primary)}
.cost-total .cost-key{color:rgba(255,255,255,.85);font-size:15px;font-weight:700}
.cost-total .cost-val{color:#fff;font-size:20px}
/* TOAST */
.toast-wrap{position:fixed;bottom:24px;right:24px;z-index:300;display:flex;flex-direction:column;gap:8px}
.toast{background:var(--white);border:1px solid var(--border);border-radius:12px;padding:14px 18px;font-size:14px;font-weight:600;display:flex;align-items:center;gap:10px;box-shadow:var(--shadow-lg);animation:ti .3s ease;min-width:280px;max-width:360px}
@keyframes ti{from{transform:translateX(16px);opacity:0}to{transform:translateX(0);opacity:1}}
.toast-ok{border-left:4px solid var(--green)}
.toast-wn{border-left:4px solid #F59E0B}
.toast-er{border-left:4px solid var(--red)}
/* EMPTY */
.empty{text-align:center;padding:48px 24px}
.empty-icon{font-size:44px;margin-bottom:12px;opacity:.45}
.empty-text{font-size:15px;color:var(--text-3);font-weight:600}
/* SEARCH */
.search-wrap{position:relative}
.search-icon{position:absolute;left:13px;top:50%;transform:translateY(-50%);color:var(--text-3);pointer-events:none}
.search-control{padding-left:40px!important}
/* PAGINATION */
.pagination{display:flex;gap:6px;align-items:center;justify-content:center;margin-top:20px;flex-wrap:wrap}
.pagination a,.pagination span{padding:7px 13px;border-radius:8px;font-size:13px;font-weight:700;border:1.5px solid var(--border-dark);background:var(--white);color:var(--text-2);text-decoration:none;transition:all .15s}
.pagination a:hover{background:var(--blue-bg);border-color:var(--blue-border);color:var(--blue)}
.pagination .active span{background:var(--primary);color:#fff;border-color:var(--primary)}
.pagination .disabled span{opacity:.4;cursor:not-allowed}
/* ALERT */
.alert{padding:14px 18px;border-radius:10px;font-size:14px;font-weight:600;margin-bottom:20px;display:flex;align-items:center;gap:10px}
.alert-success{background:var(--green-bg);border:1px solid var(--green-border);color:var(--green)}
.alert-error{background:var(--red-bg);border:1px solid var(--red-border);color:var(--red)}
/* RESPONSIVE */
@media(max-width:768px){.sidebar{display:none}.main{margin-left:0}.stats-grid{grid-template-columns:1fr 1fr}.detail-info-grid{grid-template-columns:1fr}.form-row,.form-row-3{grid-template-columns:1fr}}
::-webkit-scrollbar{width:5px;height:5px}
::-webkit-scrollbar-thumb{background:#D1D5DB;border-radius:5px}
</style>
</head>
<body>

<!-- SIDEBAR -->
<nav class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-icon">
      <svg viewBox="0 0 24 24" fill="none" stroke="#1B3A6B" stroke-width="2.5">
        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
        <polyline points="9 22 9 12 15 12 15 22"/>
      </svg>
    </div>
    <div class="logo-name">Pegadaian</div>
    <div class="logo-sub">Sistem Admin</div>
  </div>

  <div class="nav-group">
    <div class="nav-label">MENU</div>
    <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
        <rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/>
        <rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/>
      </svg>Beranda
    </a>
    <a href="{{ route('barang.index') }}" class="nav-item {{ request()->routeIs('barang.*') ? 'active' : '' }}">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
        <path d="M20 7H4a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2z"/>
        <path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/>
      </svg>Barang Gadai
    </a>
    <a href="{{ route('riwayat.index') }}" class="nav-item {{ request()->routeIs('riwayat.*') ? 'active' : '' }}">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
        <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>Riwayat
    </a>
    <a href="{{ route('keuangan.index') }}" class="nav-item {{ request()->routeIs('keuangan.*') ? 'active' : '' }}">
      <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
        <line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/>
      </svg>Keuangan
    </a>
  </div>

  <div class="sidebar-policy">
    <div class="sp-title">KETENTUAN BUNGA</div>
    <div class="sp-row"><span class="sp-key">Tebus &gt; ½ masa</span><span class="sp-val b">{{ config('pegadaian.bunga_normal') }}%</span></div>
    <div class="sp-row"><span class="sp-key">Tebus ≤ ½ masa</span><span class="sp-val g">{{ config('pegadaian.bunga_khusus') }}% ⚡</span></div>
    <div class="sp-sep"></div>
    <div class="sp-row"><span class="sp-key">Biaya perpanjang</span><span class="sp-val w">{{ config('pegadaian.biaya_perp') }}%</span></div>
  </div>

  <div class="sidebar-bottom">
    <div class="user-chip">
      <div class="user-avatar">AD</div>
      <div>
        <div class="user-name">Administrator</div>
        <div class="user-role">● Aktif</div>
      </div>
    </div>
  </div>
</nav>

<!-- MAIN -->
<div class="main">
  <div class="topbar">
    <div><div class="page-title">@yield('page-title', 'Beranda')</div></div>
    <div><div class="clock-badge" id="clk">--:--:--</div></div>
  </div>

  <div class="content">
    @if(session('success'))
      <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="alert alert-error">❌ {{ session('error') }}</div>
    @endif

    @yield('content')
  </div>
</div>

<!-- TOAST AREA -->
<div class="toast-wrap" id="toastWrap"></div>

<script>
// Clock
setInterval(()=>{
  const n=new Date();
  document.getElementById('clk').textContent=n.toLocaleTimeString('id-ID');
},1000);

// Helper format Rupiah
function fRp(n){return new Intl.NumberFormat('id-ID',{style:'currency',currency:'IDR',maximumFractionDigits:0}).format(n);}

// Toast helper
function toast(msg,type='ok'){
  const w=document.getElementById('toastWrap');
  const t=document.createElement('div');
  t.className=`toast toast-${type}`;
  t.textContent=msg;
  w.appendChild(t);
  setTimeout(()=>t.remove(),4000);
}

// Modal helpers
function openModal(id){document.getElementById(id).classList.add('open');}
function closeModal(id){document.getElementById(id).classList.remove('open');}
document.querySelectorAll('.modal-overlay').forEach(m=>{
  m.addEventListener('click',e=>{ if(e.target===m) m.classList.remove('open'); });
});
</script>
@stack('scripts')
</body>
</html>
