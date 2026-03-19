<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title>Login — Pegadaian Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Plus Jakarta Sans',sans-serif;background:#F0F4FF;min-height:100vh;display:grid;place-items:center;padding:20px}
.login-wrap{width:100%;max-width:420px}
.login-card{background:#fff;border-radius:20px;padding:40px 36px;box-shadow:0 8px 40px rgba(27,58,107,0.12)}
.logo-row{display:flex;align-items:center;gap:14px;margin-bottom:32px}
.logo-box{width:48px;height:48px;border-radius:14px;background:#1B3A6B;display:grid;place-items:center;flex-shrink:0}
.logo-title{font-size:20px;font-weight:800;color:#1B3A6B}
.logo-sub{font-size:12px;color:#6B7280;margin-top:1px}
.card-title{font-size:22px;font-weight:800;color:#111827;margin-bottom:6px}
.card-sub{font-size:14px;color:#6B7280;margin-bottom:28px}
.form-group{margin-bottom:18px}
.form-label{display:block;font-size:13px;font-weight:700;color:#374151;margin-bottom:7px}
.form-control{width:100%;padding:12px 14px;border:2px solid #D1D5DB;border-radius:10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;color:#111827;background:#fff;outline:none;transition:border-color .2s,box-shadow .2s}
.form-control:focus{border-color:#1B3A6B;box-shadow:0 0 0 3px rgba(27,58,107,0.1)}
.form-control.is-invalid{border-color:#B91C1C}
.invalid-feedback{font-size:12px;color:#B91C1C;margin-top:5px;font-weight:600}
.remember-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px}
.remember-label{display:flex;align-items:center;gap:8px;font-size:14px;color:#374151;cursor:pointer}
.btn-login{width:100%;padding:14px;border-radius:10px;background:#1B3A6B;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;cursor:pointer;border:none;transition:background .2s,transform .1s;letter-spacing:0.3px}
.btn-login:hover{background:#2E5BA8;transform:translateY(-1px)}
.btn-login:active{transform:translateY(0)}
.alert{padding:12px 16px;border-radius:10px;font-size:14px;font-weight:600;margin-bottom:20px;border:1px solid}
.alert-danger{background:#FEE2E2;color:#B91C1C;border-color:#FCA5A5}
.alert-success{background:#E8F5EE;color:#1A7F4B;border-color:#A8D9BB}
.divider{height:1px;background:#E5E7EB;margin:24px 0}
.hint-box{background:#EFF6FF;border:1px solid #BFDBFE;border-radius:10px;padding:14px 16px;font-size:13px;color:#1E40AF}
.hint-box strong{display:block;margin-bottom:6px;font-size:12px;letter-spacing:0.5px}
.hint-row{display:flex;justify-content:space-between;margin-bottom:4px}
.hint-row:last-child{margin-bottom:0}
.hint-key{color:#374151}
.hint-val{font-weight:700;font-family:monospace}
</style>
</head>
<body>

<div class="login-wrap">
  <div class="login-card">

    <div class="logo-row">
      <div class="logo-box">
        <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.5">
          <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
          <polyline points="9 22 9 12 15 12 15 22"/>
        </svg>
      </div>
      <div>
        <div class="logo-title">Pegadaian</div>
        <div class="logo-sub">Sistem Admin</div>
      </div>
    </div>

    <div class="card-title">Selamat Datang 👋</div>
    <div class="card-sub">Masuk ke panel admin untuk melanjutkan</div>

    
    <?php if(session('error')): ?>
      <div class="alert alert-danger">⚠️ <?php echo e(session('error')); ?></div>
    <?php endif; ?>
    <?php if(session('success')): ?>
      <div class="alert alert-success">✅ <?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login.post')); ?>">
      <?php echo csrf_field(); ?>

      <div class="form-group">
        <label class="form-label">Username / Email</label>
        <input type="text" name="username" class="form-control <?php echo e($errors->has('username') ? 'is-invalid' : ''); ?>"
               placeholder="Masukkan username atau email"
               value="<?php echo e(old('username')); ?>" autofocus autocomplete="username">
        <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="form-group">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control <?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>"
               placeholder="Masukkan password" autocomplete="current-password">
        <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <div class="invalid-feedback"><?php echo e($message); ?></div>
        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>

      <div class="remember-row">
        <label class="remember-label">
          <input type="checkbox" name="remember" style="width:16px;height:16px;accent-color:#1B3A6B">
          Ingat saya
        </label>
      </div>

      <button type="submit" class="btn-login">
        🔐 Masuk ke Panel Admin
      </button>
    </form>

    <div class="divider"></div>

    
    <div class="hint-box">
      <strong>🔑 AKUN DEMO</strong>
      <div class="hint-row"><span class="hint-key">Admin</span><span class="hint-val">admin / password</span></div>
      <div class="hint-row"><span class="hint-key">Kasir</span><span class="hint-val">kasir / password</span></div>
      <div class="hint-row"><span class="hint-key">Viewer</span><span class="hint-val">viewer / password</span></div>
    </div>

  </div>
</div>

</body>
</html>
<?php /**PATH C:\laragon\www\Gadai\resources\views/auth/login.blade.php ENDPATH**/ ?>