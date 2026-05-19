<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'LendLaptop') }} — Masuk / Daftar</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
<style>
/* ─── RESET & GLOBAL STYLES ───────────────────────────────── */
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --teal:       #0D9F7A;
  --teal-dark:  #0b8a6a;
  --teal-dim:   rgba(13,159,122,.12);
  --navy:       #0A1628;
  --navy-light: #12253f;
  --red:        #EF4444;
  --bg:         linear-gradient(135deg,#f0f4f8 0%,#e8edf2 100%);
  --card:       #ffffff;
  --text:       #1e293b;
  --muted:      #64748b;
  --border:     #e2e8f0;
  --input-bg:   #f8fafc;
}
body{
  font-family:'Inter',system-ui,sans-serif;
  background:var(--bg);
  min-height:100vh;
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  padding:24px 16px;
  position:relative;
  overflow-x:hidden;
  color:var(--text);
}

/* Background soft decorative shapes */
body::before{
  content:'';position:fixed;
  top:-100px;right:-100px;
  width:400px;height:400px;
  background:radial-gradient(circle,rgba(13,159,122,.1),transparent 75%);
  pointer-events:none;z-index:0;
}
body::after{
  content:'';position:fixed;
  bottom:-100px;left:-100px;
  width:350px;height:350px;
  background:radial-gradient(circle,rgba(10,22,40,.06),transparent 75%);
  pointer-events:none;z-index:0;
}

/* ─── CENTERED CARD (max-w-md) ───────────────────────────── */
.card{
  position:relative;z-index:1;
  width:100%;max-width:440px;
  background:var(--card);
  border-radius:1rem;
  box-shadow:0 10px 30px -10px rgba(10,22,40,.1), 0 1px 3px rgba(10,22,40,.05);
  border:1px solid var(--border);
  overflow:hidden;
  animation:cardFadeUp .45s cubic-bezier(.22,1,.36,1) both;
}
@keyframes cardFadeUp{
  from{opacity:0;transform:translateY(16px)}
  to{opacity:1;transform:translateY(0)}
}

/* Card Header (bg-[#0A1628]) */
.card-header{
  background:var(--navy);
  padding:32px 32px 0;
  position:relative;
  overflow:hidden;
}
.card-header::before{
  content:'';position:absolute;
  top:-30px;right:-30px;
  width:120px;height:120px;
  border-radius:50%;
  background:rgba(13,159,122,.12);
}

/* Logo Header */
.brand{
  display:flex;align-items:center;gap:12px;
  margin-bottom:24px;position:relative;z-index:1;
}
.brand-logo{
  width:40px;height:40px;
  background:var(--teal);
  border-radius:10px;
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 4px 14px rgba(13,159,122,.4);
  flex-shrink:0;
}
.brand-logo svg{color:#fff}
.brand-name{font-size:1.1rem;font-weight:700;color:#fff;letter-spacing:-.01em}
.brand-sub{font-size:.68rem;color:rgba(255,255,255,.45);margin-top:2px}

/* Tabs Navigasi (Masuk | Daftar | Reset) */
.tabs{
  display:flex;position:relative;z-index:1;
  border-bottom:1px solid rgba(255,255,255,.08);
}
.tab-btn{
  flex:1;padding:12px 6px;
  background:none;border:none;
  font-family:'Inter',sans-serif;font-size:.82rem;font-weight:600;
  color:rgba(255,255,255,.45);cursor:pointer;
  position:relative;transition:all .2s ease;
  border-bottom:2px solid transparent;
  margin-bottom:-1px;text-align:center;
  text-decoration:none;
}
.tab-btn.active{
  color:#fff;
  border-bottom-color:var(--teal);
}
.tab-btn:hover:not(.active){
  color:rgba(255,255,255,.75);
}

/* Card Body */
.card-body{
  padding:32px;
}

/* Panels switching styling */
.panel{
  display:none;
  animation:panelFadeIn .3s ease;
}
.panel.active{
  display:block;
}
@keyframes panelFadeIn{
  from{opacity:0;transform:translateY(6px)}
  to{opacity:1;transform:translateY(0)}
}

.panel-title{
  font-size:1.15rem;font-weight:700;
  color:var(--text);margin-bottom:6px;
  letter-spacing:-.01em;
}
.panel-sub{
  font-size:.82rem;color:var(--muted);
  margin-bottom:24px;
}

/* ─── INPUT FIELDS & LABELS ──────────────────────────────── */
.field{margin-bottom:18px}
.field label{
  display:block;font-size:.78rem;font-weight:600;
  color:#475569;margin-bottom:6px;
}
.field-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}

.iw{position:relative;display:flex;align-items:center}
.iw .ic{
  position:absolute;left:14px;
  color:#94a3b8;font-size:1.1rem;
  pointer-events:none;
}
.iw input{
  width:100%;padding:10px 16px 10px 42px;
  background:var(--input-bg);
  border:1px solid #cbd5e1;
  border-radius:10px;
  font-family:'Inter',sans-serif;font-size:.85rem;color:var(--text);
  outline:none;transition:all .2s ease;
}
.iw input::placeholder{color:#94a3b8}
.iw input:focus{
  border-color:var(--teal);
  background:#fff;
  box-shadow:0 0 0 4px rgba(13,159,122,.15);
}

.eye{
  position:absolute;right:14px;
  background:none;border:none;cursor:pointer;
  color:#94a3b8;font-size:1.1rem;
  transition:color .2s;
  display:flex;align-items:center;
}
.eye:hover{color:var(--teal)}
.ferr{
  margin-top:6px;font-size:.74rem;font-weight:500;
  color:var(--red);display:flex;align-items:center;gap:4px;
}

/* ─── ROLE SELECTOR (Untuk Register) ─────────────────────── */
.roles{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:18px}
.role-card{
  border:1.5px solid #e2e8f0;border-radius:10px;padding:12px;
  cursor:pointer;transition:all .2s;background:var(--input-bg);
  position:relative;
}
.role-card input{position:absolute;opacity:0;width:0;height:0}
.role-card:hover{border-color:var(--teal)}
.role-card.selected{
  border-color:var(--teal);
  background:var(--teal-dim);
}
.role-icon{
  width:32px;height:32px;border-radius:8px;
  background:#cbd5e1;display:flex;align-items:center;justify-content:center;
  margin-bottom:8px;transition:all .2s;
  color:#475569;
}
.role-icon i{font-size:1.1rem}
.role-card.selected .role-icon{
  background:var(--teal);color:#fff;
}
.role-name{font-size:.82rem;font-weight:600;color:var(--text)}
.role-desc{font-size:.7rem;color:var(--muted);margin-top:1px}

/* Password Strength Bar */
.str-bar{display:flex;gap:3px;margin-top:6px}
.str-seg{flex:1;height:3px;border-radius:2px;background:#e2e8f0;transition:background .3s}
.str-seg.s1{background:var(--red)}
.str-seg.s2{background:#F59E0B}
.str-seg.s3{background:var(--teal)}
.str-seg.s4{background:var(--navy)}
.str-lbl{font-size:.7rem;font-weight:500;color:var(--muted);text-align:right;margin-top:3px}

/* Options Row (Remember Me & Forgot Pass) */
.row-opt{
  display:flex;align-items:center;justify-content:space-between;
  margin-bottom:20px;
}
.rem{
  display:flex;align-items:center;gap:8px;
  font-size:.8rem;font-weight:500;color:var(--muted);
  cursor:pointer;user-select:none;
}
.rem input{
  accent-color:var(--teal);width:15px;height:15px;
  cursor:pointer;border-radius:4px;
}
.fgt{
  font-size:.8rem;color:var(--teal);
  text-decoration:none;font-weight:600;
  transition:color .2s;
}
.fgt:hover{color:var(--teal-dark)}

/* ─── BUTTONS ────────────────────────────────────────────── */
.btn{
  display:inline-flex;align-items:center;justify-content:center;gap:8px;
  width:100%;padding:12px;border:none;border-radius:10px;
  font-size:.88rem;font-weight:600;font-family:'Inter',sans-serif;cursor:pointer;
  transition:all .2s ease;letter-spacing:.01em;
}
.btn-primary{
  background:var(--teal);
  color:#fff;
  box-shadow:0 4px 12px rgba(13,159,122,.25);
}
.btn-primary:hover{
  background:var(--teal-dark);
  box-shadow:0 6px 18px rgba(13,159,122,.35);
  transform:translateY(-1px);
}
.btn-primary:active{transform:none}

/* Divider & Footer Links */
.flink{text-align:center;font-size:.8rem;font-weight:500;color:var(--muted);margin-top:20px}
.flink a{color:var(--teal);font-weight:600;text-decoration:none;transition:color .2s}
.flink a:hover{color:var(--teal-dark)}

.alert-ok{
  background:rgba(13,159,122,.08);
  border:1px solid rgba(13,159,122,.2);
  border-radius:8px;padding:11px 14px;
  color:#0b7a5e;font-size:.8rem;
  font-weight:500;margin-bottom:18px;
}

/* ─── RESET STEPS & SUCCESS BOX ──────────────────────────── */
.steps {
  display: flex;
  align-items: center;
  margin-bottom: 24px;
}
.snum {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: .8rem;
  flex-shrink: 0;
  transition: all .3s ease;
}
.snum.active {
  background: var(--teal);
  color: #fff;
  box-shadow: 0 3px 8px rgba(13,159,122,.25);
}
.snum.done {
  background: var(--navy);
  color: #fff;
}
.snum.idle {
  background: #e2e8f0;
  color: var(--muted);
}
.slbl {
  font-size: .78rem;
  font-weight: 500;
  color: var(--muted);
  margin-left: 8px;
}
.slbl.active {
  color: var(--text);
  font-weight: 600;
}
.sline {
  flex: 1;
  height: 2px;
  background: #e2e8f0;
  margin: 0 12px;
  border-radius: 1px;
  transition: all .3s ease;
}
.sline.done {
  background: var(--teal);
}

.success-box {
  text-align: center;
  padding: 8px 0 16px;
}
.success-ico {
  width: 60px;
  height: 60px;
  background: rgba(13,159,122,.08);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 16px;
  border: 1px solid rgba(13,159,122,.2);
}
.success-box h3 {
  font-size: 1.15rem;
  font-weight: 700;
  color: var(--text);
  margin-bottom: 8px;
}
.success-box p {
  font-size: .82rem;
  color: var(--muted);
  line-height: 1.6;
}

/* Footer Copyright */
.page-footer{
  position:relative;z-index:1;
  margin-top:24px;font-size:.78rem;
  color:#94a3b8;text-align:center;
}
</style>
</head>
<body>

<div class="card">
  <!-- Header Card (bg-[#0A1628]) -->
  <div class="card-header">
    <div class="brand">
      <div class="brand-logo" aria-hidden="true">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="3" width="20" height="14" rx="2"/>
          <path d="M8 21h8M12 17v4"/>
        </svg>
      </div>
      <div>
        <div class="brand-name">LendLaptop</div>
        <div class="brand-sub">Universitas Informatika dan Bisnis Indonesia</div>
      </div>
    </div>
    
    <!-- Tab Navigasi: Masuk | Daftar | Reset -->
    <div class="tabs" role="tablist">
      <a href="{{ route('login') }}" class="tab-btn {{ request()->routeIs('login') ? 'active' : '' }}" id="tab-login" role="tab">Masuk</a>
      <a href="{{ route('register') }}" class="tab-btn {{ request()->routeIs('register') ? 'active' : '' }}" id="tab-register" role="tab">Daftar</a>
      <a href="{{ route('password.request') }}" class="tab-btn {{ request()->routeIs('password.*') ? 'active' : '' }}" id="tab-reset" role="tab">Reset</a>
    </div>
  </div>

  <!-- Card Body -->
  <div class="card-body">

    <!-- LOGIN PANEL -->
    <div class="panel {{ request()->routeIs('login') ? 'active' : '' }}" id="panel-login" role="tabpanel">
      <div class="panel-title">Selamat Datang</div>
      <div class="panel-sub">Masuk dengan akun UNIBI LendLaptop Anda</div>
      @if(request()->routeIs('login'))
        {{ $slot }}
      @else
        @include('auth._login_form')
      @endif
    </div>

    <!-- REGISTER PANEL -->
    <div class="panel {{ request()->routeIs('register') ? 'active' : '' }}" id="panel-register" role="tabpanel">
      <div class="panel-title">Buat Akun Baru</div>
      <div class="panel-sub">Daftarkan diri untuk mulai meminjam laptop</div>
      @if(request()->routeIs('register'))
        {{ $slot }}
      @else
        @include('auth._register_form')
      @endif
    </div>

    <!-- RESET PANEL -->
    <div class="panel {{ request()->routeIs('password.*') ? 'active' : '' }}" id="panel-reset" role="tabpanel">
      <div class="panel-title">Reset Password</div>
      <div class="panel-sub">Masukkan email Anda untuk menerima link reset</div>
      @if(request()->routeIs('password.*'))
        {{ $slot }}
      @else
        @include('auth._reset_form')
      @endif
    </div>

  </div>
</div>

<!-- Copyright Footer -->
<div class="page-footer">© 2026 UNIBI · LendLaptop</div>

<script>
// Eye toggler helper
document.addEventListener('click', function(e) {
  var btn = e.target.closest('.eye');
  if (!btn) return;
  var inp = btn.closest('.iw').querySelector('input');
  var show = inp.type === 'password';
  inp.type = show ? 'text' : 'password';
  btn.innerHTML = show
    ? '<i class="ti ti-eye-off"></i>'
    : '<i class="ti ti-eye"></i>';
});

// Role card selections
document.addEventListener('click', function(e) {
  var card = e.target.closest('.role-card');
  if (!card) return;
  var grp = card.dataset.group;
  document.querySelectorAll('.role-card[data-group="' + grp + '"]').forEach(c => c.classList.remove('selected'));
  card.classList.add('selected');
  card.querySelector('input').checked = true;
  if (grp === 'role') {
    var kf = document.getElementById('kelas-field');
    if (kf) kf.style.display = card.dataset.val === 'user' ? 'block' : 'none';
  }
});

// Password strength indicator
document.addEventListener('input', function(e) {
  if (e.target.id !== 'reg-password') return;
  var v = e.target.value, s = 0;
  if (v.length >= 8) s++;
  if (/[A-Z]/.test(v)) s++;
  if (/[0-9]/.test(v)) s++;
  if (/[^A-Za-z0-9]/.test(v)) s++;
  
  var segs = document.querySelectorAll('.str-seg');
  var cls = ['', 's1', 's2', 's3', 's4'];
  var lbs = ['', 'Lemah', 'Cukup', 'Kuat', 'Sangat Kuat'];
  segs.forEach((seg, i) => seg.className = 'str-seg' + (i < s ? ' ' + cls[s] : ''));
  var lbl = document.getElementById('str-lbl');
  if (lbl) lbl.textContent = v.length ? lbs[s] : '';
});

// Form loading visual state on submit
document.querySelectorAll('form').forEach(function(f) {
  f.addEventListener('submit', function() {
    var btn = f.querySelector('.btn-primary');
    if (btn) {
      btn.innerHTML = '<i class="ti ti-loader animate-spin"></i> Memproses...';
      btn.disabled = true;
      btn.style.opacity = '.75';
    }
  });
});
</script>
</body>
</html>
