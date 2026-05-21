  <!DOCTYPE html>
  <html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') — {{ config('app.name', 'LendLaptop') }}</title>
  <meta name="description" content="@yield('meta_description', 'LendLaptop Admin Panel – Universitas Informatika dan Bisnis Indonesia')">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
  <style>
  /* ─── RESET & BASE ─────────────────────────────────────────── */
  *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
  :root{
    --teal:       #0D9F7A;
    --teal-dark:  #0b8a6a;
    --teal-dim:   rgba(13,159,122,.15);
    --teal-border:rgba(13,159,122,.35);
    --navy:       #0A1628;
    --navy-2:     #0f1f38;
    --navy-3:     #162844;
    --red:        #EF4444;
    --amber:      #F59E0B;
    --blue:       #3B82F6;
    --bg:         linear-gradient(135deg,#f0f4f8 0%,#e8edf2 100%);
    --card:       #ffffff;
    --text:       #1e293b;
    --muted:      #64748b;
    --border:     #e2e8f0;
    --sidebar-w:  16rem;
  }
  html{height:100%}
  body{
    font-family:'Inter',system-ui,sans-serif;
    background:var(--bg);
    min-height:100vh;
    color:var(--text);
    font-size:0.875rem;
  }

  /* ─── SIDEBAR ──────────────────────────────────────────────── */
  .sidebar{
    position:fixed;top:0;left:0;
    width:var(--sidebar-w);height:100vh;
    background:var(--navy);
    display:flex;flex-direction:column;
    z-index:100;
    overflow:hidden;
    transition:transform .25s ease;
  }

  /* subtle inner glow */
  .sidebar::before{
    content:'';position:absolute;
    top:-80px;right:-80px;
    width:220px;height:220px;
    background:radial-gradient(circle,rgba(13,159,122,.12),transparent 70%);
    pointer-events:none;
  }

  /* Brand / Logo */
  .sb-brand{
    display:flex;align-items:center;gap:12px;
    padding:22px 20px 18px;
    border-bottom:1px solid rgba(255,255,255,.06);
    position:relative;z-index:1;
  }
  .sb-logo{
    width:40px;height:40px;flex-shrink:0;
    background:var(--teal);border-radius:10px;
    display:flex;align-items:center;justify-content:center;
    box-shadow:0 4px 14px rgba(13,159,122,.4);
  }
  .sb-logo svg{color:#fff}
  .sb-title{font-size:.95rem;font-weight:700;color:#fff;letter-spacing:-.01em;line-height:1.2}
  .sb-sub{font-size:.6rem;color:rgba(255,255,255,.4);margin-top:2px;line-height:1.3}

  /* Admin Info */
  .sb-admin{
    display:flex;align-items:center;gap:11px;
    margin:14px 14px 10px;
    padding:12px 14px;
    background:rgba(255,255,255,.04);
    border-radius:12px;
    border:1px solid rgba(255,255,255,.06);
  }
  .sb-avatar{
    width:36px;height:36px;flex-shrink:0;border-radius:10px;
    background:var(--teal);
    display:flex;align-items:center;justify-content:center;
    font-weight:700;font-size:.8rem;color:#fff;
    box-shadow:0 2px 8px rgba(13,159,122,.35);
  }
  .sb-admin-name{font-size:.78rem;font-weight:600;color:#fff;line-height:1.2}
  .sb-admin-role{font-size:.65rem;color:rgba(255,255,255,.4);margin-top:1px}

  /* Nav */
  .sb-nav{flex:1;overflow-y:auto;padding:6px 10px;scrollbar-width:thin;scrollbar-color:rgba(255,255,255,.08) transparent}
  .sb-nav::-webkit-scrollbar{width:4px}
  .sb-nav::-webkit-scrollbar-thumb{background:rgba(255,255,255,.1);border-radius:4px}

  .nav-section{font-size:.6rem;font-weight:600;color:rgba(255,255,255,.28);
    text-transform:uppercase;letter-spacing:.08em;padding:14px 10px 6px}

  .nav-item{
    display:flex;align-items:center;gap:11px;
    padding:10px 12px;
    border-radius:10px;
    color:rgba(255,255,255,.55);
    text-decoration:none;
    font-size:.81rem;font-weight:500;
    transition:all .18s ease;
    margin-bottom:2px;
    position:relative;
    border-left:2px solid transparent;
  }
  .nav-item i{font-size:1.05rem;flex-shrink:0;transition:color .18s}
  .nav-item:hover{
    background:rgba(255,255,255,.06);
    color:rgba(255,255,255,.85);
  }
  .nav-item.active{
    background:var(--teal-dim);
    color:var(--teal);
    border-left-color:var(--teal);
    font-weight:600;
  }
  .nav-item.active i{color:var(--teal)}
  .nav-badge{
    margin-left:auto;
    background:var(--teal);color:#fff;
    font-size:.58rem;font-weight:700;
    padding:2px 7px;border-radius:20px;
    line-height:1.5;
  }

  /* Logout */
  .sb-footer{padding:12px 10px 18px;border-top:1px solid rgba(255,255,255,.06)}
  .btn-logout{
    display:flex;align-items:center;gap:10px;
    width:100%;padding:10px 12px;border-radius:10px;
    background:none;border:1px solid rgba(255,255,255,.08);
    color:rgba(255,255,255,.45);font-family:'Inter',sans-serif;
    font-size:.8rem;font-weight:500;cursor:pointer;
    transition:all .18s ease;text-decoration:none;
  }
  .btn-logout i{font-size:1rem}
  .btn-logout:hover{
    background:rgba(239,68,68,.12);
    border-color:rgba(239,68,68,.3);
    color:#f87171;
  }

  /* ─── MAIN AREA ────────────────────────────────────────────── */
  .main{margin-left:var(--sidebar-w);min-height:100vh;display:flex;flex-direction:column}

  /* ─── TOPBAR ───────────────────────────────────────────────── */
  .topbar{
    position:sticky;top:0;z-index:50;
    background:rgba(255,255,255,.9);
    backdrop-filter:blur(12px);
    -webkit-backdrop-filter:blur(12px);
    border-bottom:1px solid var(--border);
    padding:0 24px;
    height:64px;
    display:flex;align-items:center;gap:16px;
  }
  .topbar-title-area{flex:1;min-width:0}
  .topbar-title{
    font-size:1rem;font-weight:700;color:var(--text);
    white-space:nowrap;overflow:hidden;text-overflow:ellipsis;
  }
  .topbar-breadcrumb{
    display:flex;align-items:center;gap:6px;
    font-size:.72rem;color:var(--muted);margin-top:1px;
  }
  .topbar-breadcrumb a{color:var(--teal);text-decoration:none;font-weight:500}
  .topbar-breadcrumb a:hover{color:var(--teal-dark)}
  .topbar-breadcrumb span{color:#cbd5e1}

  .topbar-actions{display:flex;align-items:center;gap:8px}
  .topbar-btn{
    width:38px;height:38px;border-radius:10px;
    background:none;border:1px solid var(--border);
    display:flex;align-items:center;justify-content:center;
    cursor:pointer;color:var(--muted);
    transition:all .18s ease;position:relative;text-decoration:none;
  }
  .topbar-btn:hover{background:#f8fafc;color:var(--teal);border-color:var(--teal-border)}
  .topbar-btn i{font-size:1.1rem}
  .notif-dot{
    position:absolute;top:7px;right:7px;
    width:7px;height:7px;border-radius:50%;
    background:var(--red);border:1.5px solid #fff;
  }
  .topbar-avatar{
    width:36px;height:36px;border-radius:10px;
    background:var(--teal);
    display:flex;align-items:center;justify-content:center;
    font-weight:700;font-size:.78rem;color:#fff;
    cursor:pointer;
    box-shadow:0 2px 8px rgba(13,159,122,.3);
    border:2px solid rgba(13,159,122,.2);
    transition:transform .15s;
  }
  .topbar-avatar:hover{transform:scale(1.05)}

  /* ─── FLASH MESSAGES ───────────────────────────────────────── */
  .flash-wrap{padding:16px 24px 0}
  .flash{
    display:flex;align-items:flex-start;gap:12px;
    padding:13px 16px;border-radius:12px;
    font-size:.82rem;font-weight:500;
    animation:slideDown .3s cubic-bezier(.22,1,.36,1) both;
    position:relative;overflow:hidden;
  }
  @keyframes slideDown{from{opacity:0;transform:translateY(-8px)}}
  .flash::before{
    content:'';position:absolute;left:0;top:0;bottom:0;width:3px;border-radius:0;
  }
  .flash-success{background:rgba(13,159,122,.08);color:#0b7a5e;border:1px solid rgba(13,159,122,.2)}
  .flash-success::before{background:var(--teal)}
  .flash-error{background:rgba(239,68,68,.07);color:#b91c1c;border:1px solid rgba(239,68,68,.2)}
  .flash-error::before{background:var(--red)}
  .flash-warning{background:rgba(245,158,11,.07);color:#92400e;border:1px solid rgba(245,158,11,.2)}
  .flash-warning::before{background:var(--amber)}
  .flash-info{background:rgba(59,130,246,.07);color:#1d4ed8;border:1px solid rgba(59,130,246,.2)}
  .flash-info::before{background:var(--blue)}
  .flash i{font-size:1.05rem;flex-shrink:0;margin-top:1px}
  .flash-close{
    margin-left:auto;background:none;border:none;cursor:pointer;
    font-size:.85rem;opacity:.5;flex-shrink:0;padding:2px 4px;
    transition:opacity .15s;line-height:1;
  }
  .flash-close:hover{opacity:1}

  /* ─── CONTENT ──────────────────────────────────────────────── */
  .content{flex:1;padding:24px;background:transparent}

  /* ─── PAGE FOOTER ──────────────────────────────────────────── */
  .page-footer{
    text-align:center;padding:16px 24px;
    font-size:.72rem;color:#94a3b8;
    border-top:1px solid var(--border);
    background:rgba(255,255,255,.5);
  }

  /* ─── CARD UTILITY ─────────────────────────────────────────── */
  .card{
    background:var(--card);border-radius:1rem;
    box-shadow:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);
    border:1px solid #f1f5f9;
  }

  /* ─── BADGE UTILITIES ──────────────────────────────────────── */
  .badge{display:inline-flex;align-items:center;gap:5px;padding:3px 10px;border-radius:9999px;font-size:.7rem;font-weight:600;line-height:1.5}
  .badge-teal{background:rgba(13,159,122,.1);color:#0b7a5e}
  .badge-blue{background:rgba(59,130,246,.1);color:#1d4ed8}
  .badge-amber{background:rgba(245,158,11,.1);color:#92400e}
  .badge-red{background:rgba(239,68,68,.1);color:#b91c1c}

  /* ─── MOBILE TOGGLE ────────────────────────────────────────── */
  .mob-toggle{
    display:none;width:38px;height:38px;border-radius:10px;
    background:none;border:1px solid var(--border);
    align-items:center;justify-content:center;
    cursor:pointer;color:var(--muted);
  }
  .mob-toggle i{font-size:1.2rem}
  .sidebar-overlay{
    display:none;position:fixed;inset:0;
    background:rgba(0,0,0,.4);z-index:99;
    backdrop-filter:blur(2px);
  }

  /* ─── RESPONSIVE ───────────────────────────────────────────── */
  @media(max-width:1023px){
    .sidebar{transform:translateX(-100%)}
    .sidebar.open{transform:translateX(0)}
    .main{margin-left:0}
    .mob-toggle{display:flex}
    .sidebar-overlay.open{display:block}
  }
  </style>
  @stack('styles')
  </head>
  <body>

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  SIDEBAR                                                    --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <aside class="sidebar" id="sidebar" role="navigation" aria-label="Sidebar navigasi admin">

    {{-- Brand --}}
    <div class="sb-brand">
      <div class="sb-logo" aria-hidden="true">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
          <rect x="2" y="3" width="20" height="14" rx="2"/>
          <path d="M8 21h8M12 17v4"/>
        </svg>
      </div>
      <div>
        <div class="sb-title">LendLaptop</div>
        <div class="sb-sub">Universitas Informatika dan Bisnis Indonesia</div>
      </div>
    </div>

    {{-- Admin Info --}}
    <div class="sb-admin">
      <div class="sb-avatar" aria-hidden="true">
        {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
      </div>
      <div>
        <div class="sb-admin-name">{{ Auth::user()->name ?? 'Administrator' }}</div>
        <div class="sb-admin-role">Administrator</div>
      </div>
    </div>

    {{-- Navigation --}}
    <nav class="sb-nav">
      <div class="nav-section">Menu Utama</div>

      <a href="{{ route('admin.dashboard') }}"
        class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
        id="nav-dashboard">
        <i class="ti ti-layout-dashboard"></i>
        Dashboard
      </a>

      <a href="{{ route('admin.laptops.index') }}"
        class="nav-item {{ request()->routeIs('admin.laptops.*') ? 'active' : '' }}"
        id="nav-laptops">
        <i class="ti ti-device-laptop"></i>
        Kelola Laptop
      </a>

      <a href="{{ route('admin.categories.index') }}"
        class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
        id="nav-categories">
        <i class="ti ti-tag"></i>
        Kategori
      </a>

      <div class="nav-section">Transaksi</div>

      <a href="{{ route('admin.borrowings.index') }}"
        class="nav-item {{ request()->routeIs('admin.borrowings.*') ? 'active' : '' }}"
        id="nav-borrowings">
        <i class="ti ti-clipboard-list"></i>
        Peminjaman
        @php $pendingBorrow = \App\Models\Borrowing::where('status','pending')->count() @endphp
        @if($pendingBorrow > 0)
          <span class="nav-badge">{{ $pendingBorrow }}</span>
        @endif
      </a>

      <a href="{{ route('admin.returns.index') }}"
        class="nav-item {{ request()->routeIs('admin.returns.*') ? 'active' : '' }}"
        id="nav-returns">
        <i class="ti ti-clipboard-check"></i>
        Pengembalian
      </a>

      <a href="{{ route('admin.maintenances.index') }}"
        class="nav-item {{ request()->routeIs('admin.maintenances.*') ? 'active' : '' }}"
        id="nav-maintenance">
        <i class="ti ti-tools"></i>
        Maintenance
      </a>

      <div class="nav-section">Sistem</div>

      <a href="{{ route('admin.users.index') }}"
        class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}"
        id="nav-users">
        <i class="ti ti-users"></i>
        Pengguna
      </a>

      <a href="{{ route('admin.reports.index') }}"
        class="nav-item {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
        id="nav-reports">
        <i class="ti ti-chart-bar"></i>
        Laporan
      </a>
    </nav>

    {{-- Logout --}}
    <div class="sb-footer">
      <form method="POST" action="{{ route('logout') }}" id="logout-form">
        @csrf
        <button type="submit" class="btn-logout" id="btn-logout">
          <i class="ti ti-logout"></i>
          Keluar dari Sistem
        </button>
      </form>
    </div>
  </aside>

  {{-- Overlay (mobile) --}}
  <div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  MAIN AREA                                                  --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <div class="main" id="main-content">

    {{-- ── TOPBAR ── --}}
    <header class="topbar" role="banner">
      {{-- Mobile toggle --}}
      <button class="mob-toggle" id="mob-toggle" onclick="openSidebar()" aria-label="Buka sidebar">
        <i class="ti ti-menu-2"></i>
      </button>

      {{-- Title + Breadcrumb --}}
      <div class="topbar-title-area">
        <div class="topbar-title">@yield('page_title', 'Dashboard')</div>
        <nav class="topbar-breadcrumb" aria-label="Breadcrumb">
          <a href="{{ route('admin.dashboard') }}">LendLaptop</a>
          <span>/</span>
          @yield('breadcrumb', '<span style="color:#64748b">Dashboard</span>')
        </nav>
      </div>

      {{-- Actions --}}
      <div class="topbar-actions">
        {{-- Notification bell --}}
        <button class="topbar-btn" id="btn-notif" aria-label="Notifikasi" title="Notifikasi">
          <i class="ti ti-bell"></i>
          <span class="notif-dot" id="notif-dot"></span>
        </button>

        {{-- Full screen --}}
        <button class="topbar-btn" id="btn-fullscreen" onclick="toggleFullscreen()" aria-label="Layar penuh" title="Layar penuh">
          <i class="ti ti-maximize" id="fs-icon"></i>
        </button>

        {{-- Avatar --}}
        <div class="topbar-avatar" id="topbar-avatar" title="{{ Auth::user()->name ?? 'Admin' }}">
          {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
        </div>
      </div>
    </header>

    {{-- ── FLASH MESSAGES ── --}}
    @if(session()->hasAny(['success','error','warning','info']))
    <div class="flash-wrap" id="flash-container" role="alert" aria-live="polite">
      @if(session('success'))
      <div class="flash flash-success" id="flash-success">
        <i class="ti ti-circle-check"></i>
        <span>{{ session('success') }}</span>
        <button class="flash-close" onclick="dismissFlash('flash-success')" aria-label="Tutup">&times;</button>
      </div>
      @endif
      @if(session('error'))
      <div class="flash flash-error" id="flash-error">
        <i class="ti ti-alert-circle"></i>
        <span>{{ session('error') }}</span>
        <button class="flash-close" onclick="dismissFlash('flash-error')" aria-label="Tutup">&times;</button>
      </div>
      @endif
      @if(session('warning'))
      <div class="flash flash-warning" id="flash-warning">
        <i class="ti ti-alert-triangle"></i>
        <span>{{ session('warning') }}</span>
        <button class="flash-close" onclick="dismissFlash('flash-warning')" aria-label="Tutup">&times;</button>
      </div>
      @endif
      @if(session('info'))
      <div class="flash flash-info" id="flash-info">
        <i class="ti ti-info-circle"></i>
        <span>{{ session('info') }}</span>
        <button class="flash-close" onclick="dismissFlash('flash-info')" aria-label="Tutup">&times;</button>
      </div>
      @endif
    </div>
    @endif

    {{-- ── CONTENT SLOT ── --}}
    <main class="content" id="page-content">
      @yield('content')
    </main>

    {{-- ── FOOTER ── --}}
    <footer class="page-footer" role="contentinfo">
      © 2026 UNIBI · LendLaptop
    </footer>

  </div>{{-- /.main --}}

  <script>
  /* ─ Sidebar mobile ─ */
  function openSidebar(){
    document.getElementById('sidebar').classList.add('open');
    document.getElementById('sidebar-overlay').classList.add('open');
    document.body.style.overflow='hidden';
  }
  function closeSidebar(){
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('open');
    document.body.style.overflow='';
  }

  /* ─ Flash auto-dismiss (3 s) ─ */
  function dismissFlash(id){
    var el=document.getElementById(id);
    if(!el)return;
    el.style.transition='opacity .3s,transform .3s';
    el.style.opacity='0';
    el.style.transform='translateY(-6px)';
    setTimeout(function(){el.remove();cleanFlashWrap()},300);
  }
  function cleanFlashWrap(){
    var w=document.getElementById('flash-container');
    if(w&&!w.children.length)w.remove();
  }
  document.addEventListener('DOMContentLoaded',function(){
    ['flash-success','flash-error','flash-warning','flash-info'].forEach(function(id){
      var el=document.getElementById(id);
      if(el)setTimeout(function(){dismissFlash(id)},3000);
    });
  });

  /* ─ Fullscreen ─ */
  function toggleFullscreen(){
    var icon=document.getElementById('fs-icon');
    if(!document.fullscreenElement){
      document.documentElement.requestFullscreen();
      if(icon){icon.classList.remove('ti-maximize');icon.classList.add('ti-minimize')}
    } else {
      document.exitFullscreen();
      if(icon){icon.classList.remove('ti-minimize');icon.classList.add('ti-maximize')}
    }
  }
  </script>
  @stack('scripts')
  </body>
  </html>
