<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name','LendLaptop') }} — Login</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}

:root{
  --teal:     #1BBCB5;
  --teal-dark:#13948E;
  --teal-dim: rgba(27,188,181,.12);
  --navy:     #1B3E52;
  --red:      #E63946;
  --bg:       #F0F7F7;
  --card:     #ffffff;
  --text:     #1B3E52;
  --muted:    #6B8FA0;
  --border:   #D4E8E7;
  --input-bg: #F5FAFA;
}

body{
  font-family:'Inter',sans-serif;
  background:var(--bg);
  min-height:100vh;
  display:flex;
  flex-direction:column;
  align-items:center;
  justify-content:center;
  padding:24px 16px;
  position:relative;
  overflow:hidden;
}

/* BG decoration */
body::before{
  content:'';position:fixed;
  top:-120px;right:-120px;
  width:420px;height:420px;
  background:radial-gradient(circle,rgba(27,188,181,.18),transparent 70%);
  pointer-events:none;z-index:0;
}
body::after{
  content:'';position:fixed;
  bottom:-100px;left:-100px;
  width:350px;height:350px;
  background:radial-gradient(circle,rgba(27,93,130,.12),transparent 70%);
  pointer-events:none;z-index:0;
}

/* CARD */
.card{
  position:relative;z-index:1;
  width:100%;max-width:420px;
  background:var(--card);
  border-radius:20px;
  box-shadow:0 8px 40px rgba(27,62,82,.1), 0 1px 3px rgba(27,62,82,.06);
  overflow:hidden;
  animation:up .5s cubic-bezier(.22,1,.36,1) both;
}
@keyframes up{from{opacity:0;transform:translateY(20px)}}

/* CARD HEADER */
.card-header{
  background:linear-gradient(135deg,var(--navy) 0%,#1B5F7A 100%);
  padding:28px 32px 0;
  position:relative;
  overflow:hidden;
}
.card-header::before{
  content:'';position:absolute;
  top:-40px;right:-40px;
  width:140px;height:140px;
  border-radius:50%;
  background:rgba(27,188,181,.12);
}
.brand{display:flex;align-items:center;gap:12px;margin-bottom:20px;position:relative}
.brand-logo{
  width:42px;height:42px;
  background:var(--teal);
  border-radius:12px;
  display:flex;align-items:center;justify-content:center;
  box-shadow:0 4px 16px rgba(27,188,181,.4);
  flex-shrink:0;
}
.brand-logo svg{color:#fff}
.brand-name{font-size:1.15rem;font-weight:700;color:#fff;letter-spacing:-.01em}
.brand-sub{font-size:.72rem;color:rgba(255,255,255,.55);margin-top:1px}

/* TABS */
.tabs{display:flex;position:relative;z-index:1}
.tab-btn{
  flex:1;padding:12px 8px;
  background:none;border:none;
  font-family:'Inter',sans-serif;font-size:.82rem;font-weight:500;
  color:rgba(255,255,255,.5);cursor:pointer;
  position:relative;transition:color .2s;
  border-bottom:2px solid transparent;
  margin-bottom:-1px;
}
.tab-btn.active{color:#fff;border-bottom-color:var(--teal)}
.tab-btn:hover:not(.active){color:rgba(255,255,255,.75)}

/* BODY */
.card-body{padding:28px 32px 24px}

/* PANEL */
.panel{display:none;animation:fadeIn .25s ease}
.panel.active{display:block}
@keyframes fadeIn{from{opacity:0;transform:translateY(6px)}}

.panel-title{font-size:1.1rem;font-weight:700;color:var(--text);margin-bottom:4px}
.panel-sub{font-size:.8rem;color:var(--muted);margin-bottom:22px}

/* FIELDS */
.field{margin-bottom:14px}
.field label{display:block;font-size:.78rem;font-weight:500;color:var(--muted);margin-bottom:6px}
.field-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.iw{position:relative}
.iw .ic{position:absolute;left:12px;top:50%;transform:translateY(-50%);color:#A8C4CE;pointer-events:none}
.iw input{
  width:100%;padding:11px 12px 11px 38px;
  background:var(--input-bg);
  border:1.5px solid var(--border);
  border-radius:10px;
  font-family:'Inter',sans-serif;font-size:.875rem;color:var(--text);
  outline:none;transition:all .2s;
}
.iw input::placeholder{color:#B0CADA}
.iw input:focus{border-color:var(--teal);background:#fff;box-shadow:0 0 0 3px rgba(27,188,181,.12)}
.eye{position:absolute;right:11px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:#A8C4CE;transition:color .2s}
.eye:hover{color:var(--teal)}
.ferr{margin-top:5px;font-size:.74rem;color:var(--red);display:flex;align-items:center;gap:4px}

/* ROLES */
.roles{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:14px}
.role-card{
  border:1.5px solid var(--border);border-radius:10px;padding:12px;
  cursor:pointer;transition:all .2s;background:var(--input-bg);
  position:relative;
}
.role-card input{position:absolute;opacity:0;width:0;height:0}
.role-card:hover{border-color:var(--teal)}
.role-card.selected{border-color:var(--teal);background:var(--teal-dim)}
.role-icon{width:30px;height:30px;border-radius:8px;background:var(--border);display:flex;align-items:center;justify-content:center;margin-bottom:7px;transition:background .2s}
.role-card.selected .role-icon{background:var(--teal);color:#fff}
.role-icon svg{color:#6B8FA0}
.role-card.selected .role-icon svg{color:#fff}
.role-name{font-size:.82rem;font-weight:600;color:var(--text)}
.role-desc{font-size:.7rem;color:var(--muted)}

/* PASSWORD STRENGTH */
.str-bar{display:flex;gap:3px;margin-top:5px}
.str-seg{flex:1;height:3px;border-radius:2px;background:var(--border);transition:background .3s}
.str-seg.s1{background:#E63946}.str-seg.s2{background:#F4A261}.str-seg.s3{background:var(--teal)}.str-seg.s4{background:#1B3E52}
.str-lbl{font-size:.7rem;color:var(--muted);text-align:right;margin-top:2px}

/* OPTIONS ROW */
.row-opt{display:flex;align-items:center;justify-content:space-between;margin-bottom:18px}
.rem{display:flex;align-items:center;gap:7px;font-size:.8rem;color:var(--muted);cursor:pointer;user-select:none}
.rem input{accent-color:var(--teal);width:14px;height:14px;cursor:pointer}
.fgt{font-size:.8rem;color:var(--teal);text-decoration:none;font-weight:500}
.fgt:hover{color:var(--teal-dark)}

/* BUTTON */
.btn{
  width:100%;padding:12px;border:none;border-radius:10px;
  font-size:.9rem;font-weight:600;font-family:'Inter',sans-serif;cursor:pointer;
  transition:all .2s;letter-spacing:.01em;
}
.btn-primary{
  background:linear-gradient(135deg,var(--teal),var(--teal-dark));
  color:#fff;
  box-shadow:0 4px 18px rgba(27,188,181,.3);
}
.btn-primary:hover{box-shadow:0 6px 24px rgba(27,188,181,.45);transform:translateY(-1px)}
.btn-primary:active{transform:none}

/* DIVIDER */
.flink{text-align:center;font-size:.8rem;color:var(--muted);margin-top:16px}
.flink a{color:var(--teal);font-weight:500;text-decoration:none}
.flink a:hover{color:var(--teal-dark)}

/* ALERT */
.alert-ok{background:rgba(27,188,181,.08);border:1px solid rgba(27,188,181,.3);border-radius:8px;padding:10px 14px;color:var(--teal-dark);font-size:.82rem;margin-bottom:14px}

/* STEP INDICATOR */
.steps{display:flex;align-items:center;margin-bottom:20px}
.snum{width:26px;height:26px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:600;font-size:.76rem;flex-shrink:0;transition:all .3s}
.snum.active{background:var(--teal);color:#fff}
.snum.done{background:var(--navy);color:#fff}
.snum.idle{background:var(--border);color:var(--muted)}
.slbl{font-size:.76rem;color:var(--muted);margin-left:6px}
.slbl.active{color:var(--text);font-weight:500}
.sline{flex:1;height:2px;background:var(--border);margin:0 10px;border-radius:1px;transition:background .3s}
.sline.done{background:var(--teal)}

/* SUCCESS */
.success-box{text-align:center;padding:8px 0 12px}
.success-ico{width:58px;height:58px;background:rgba(27,188,181,.1);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
.success-ico svg{color:var(--teal)}
.success-box h3{font-size:1.1rem;font-weight:700;color:var(--text);margin-bottom:6px}
.success-box p{font-size:.82rem;color:var(--muted);line-height:1.6}

/* FOOTER */
.page-footer{position:relative;z-index:1;margin-top:20px;font-size:.75rem;color:#A8C4CE;text-align:center}
</style>
</head>
<body>

<div class="card">
  <!-- Header -->
  <div class="card-header">
    <div class="brand">
      <div class="brand-logo">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
      </div>
      <div>
        <div class="brand-name">LendLaptop</div>
        <div class="brand-sub">Universitas Informatika dan Bisnis Indonesia</div>
      </div>
    </div>
    <!-- Tabs -->
    <div class="tabs">
      <button class="tab-btn {{ request()->routeIs('login') ? 'active' : '' }}" id="tab-login" onclick="switchTab('login')">Masuk</button>
      <button class="tab-btn {{ request()->routeIs('register') ? 'active' : '' }}" id="tab-register" onclick="switchTab('register')">Daftar</button>
      <button class="tab-btn {{ request()->routeIs('password.*') ? 'active' : '' }}" id="tab-reset" onclick="switchTab('reset')">Reset</button>
    </div>
  </div>

  <!-- Body -->
  <div class="card-body">

    <!-- LOGIN -->
    <div class="panel {{ request()->routeIs('login') ? 'active' : '' }}" id="panel-login">
      <div class="panel-title">Selamat Datang 👋</div>
      <div class="panel-sub">Masuk dengan akun UNIBI LendLaptop Anda</div>
      @if(request()->routeIs('login'))
        {{ $slot }}
      @else
        @include('auth._login_form')
      @endif
    </div>

    <!-- REGISTER -->
    <div class="panel {{ request()->routeIs('register') ? 'active' : '' }}" id="panel-register">
      <div class="panel-title">Buat Akun Baru ✨</div>
      <div class="panel-sub">Daftarkan diri untuk mulai meminjam laptop</div>
      @if(request()->routeIs('register'))
        {{ $slot }}
      @else
        @include('auth._register_form')
      @endif
    </div>

    <!-- RESET -->
    <div class="panel {{ request()->routeIs('password.*') ? 'active' : '' }}" id="panel-reset">
      <div class="panel-title">Reset Password 🔐</div>
      <div class="panel-sub">Kami kirimkan link ke email Anda</div>
      @if(request()->routeIs('password.*'))
        {{ $slot }}
      @else
        @include('auth._reset_form')
      @endif
    </div>

  </div>
</div>

<div class="page-footer">© {{ date('Y') }} UNIBI · LendLaptop</div>

<script>
function switchTab(t){
  document.querySelectorAll('.tab-btn').forEach(b=>b.classList.remove('active'));
  document.querySelectorAll('.panel').forEach(p=>p.classList.remove('active'));
  document.getElementById('tab-'+t).classList.add('active');
  document.getElementById('panel-'+t).classList.add('active');
  var urls={login:'/login',register:'/register',reset:'/forgot-password'};
  window.history.pushState({},'',(urls[t]));
}

// Eye toggle
document.addEventListener('click',function(e){
  var btn=e.target.closest('.eye');
  if(!btn)return;
  var inp=btn.closest('.iw').querySelector('input');
  var show=inp.type==='password';
  inp.type=show?'text':'password';
  btn.innerHTML=show
    ?'<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>'
    :'<svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>';
});

// Role cards
document.addEventListener('click',function(e){
  var card=e.target.closest('.role-card');
  if(!card)return;
  var grp=card.dataset.group;
  document.querySelectorAll('.role-card[data-group="'+grp+'"]').forEach(c=>c.classList.remove('selected'));
  card.classList.add('selected');
  card.querySelector('input').checked=true;
  if(grp==='role'){
    var kf=document.getElementById('kelas-field');
    if(kf)kf.style.display=card.dataset.val==='user'?'block':'none';
  }
});

// Password strength
document.addEventListener('input',function(e){
  if(e.target.id!=='reg-password')return;
  var v=e.target.value,s=0;
  if(v.length>=8)s++;if(/[A-Z]/.test(v))s++;if(/[0-9]/.test(v))s++;if(/[^A-Za-z0-9]/.test(v))s++;
  var segs=document.querySelectorAll('.str-seg');
  var cls=['','s1','s2','s3','s4'];
  var lbs=['','Lemah','Cukup','Kuat','Sangat Kuat'];
  segs.forEach((seg,i)=>seg.className='str-seg'+(i<s?' '+cls[s]:''));
  var lbl=document.getElementById('str-lbl');
  if(lbl)lbl.textContent=v.length?lbs[s]:'';
});

// Form loading state
document.querySelectorAll('form').forEach(function(f){
  f.addEventListener('submit',function(){
    var btn=f.querySelector('.btn-primary');
    if(btn){btn.textContent='Memproses...';btn.disabled=true;btn.style.opacity='.7'}
  });
});
</script>
</body>
</html>
