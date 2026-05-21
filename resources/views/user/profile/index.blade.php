@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div style="max-w: 1200px; margin: 0 auto; font-family: 'Inter', sans-serif;">

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  BREADCRUMB                                                --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <div style="margin-bottom: 20px; font-size: 13px; color: #64748b;">
    <a href="{{ route('user.dashboard') }}" style="color: #64748b; text-decoration: none;">Dashboard</a>
    <span style="margin: 0 8px;">/</span>
    <span style="color: #0A1628; font-weight: 500;">Profil Saya</span>
  </div>

  {{-- Flash Alerts --}}

  @if(session('status') === 'password-updated')
    <div style="background-color: rgba(13,159,122,0.06); border: 1px solid rgba(13,159,122,0.15); border-radius: 8px; padding: 12px 16px; color: #0D9F7A; font-size: 13px; margin-bottom: 20px; display: flex; align-items: center; gap: 8px;">
      <i class="ti ti-circle-check" style="font-size: 16px;"></i>
      <span>Password berhasil diubah!</span>
    </div>
  @endif

  @if($errors->any())
    <div style="background-color: rgba(239,68,68,0.06); border: 1px solid rgba(239,68,68,0.15); border-radius: 8px; padding: 12px 16px; color: #EF4444; font-size: 13px; margin-bottom: 20px;">
      <strong style="display: block; margin-bottom: 4px;">Terjadi kesalahan:</strong>
      <ul style="margin: 0; padding-left: 16px;">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  PROFILE HEADER BANNER                                      --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <div style="background: #0A1628; border-radius: 16px; padding: 24px; display: flex; align-items: center; justify-content: space-between; gap: 20px; color: #fff; margin-bottom: 24px; flex-wrap: wrap;">
    <!-- Left Info -->
    <div style="display: flex; align-items: center; gap: 16px; flex: 1; min-width: 280px;">
      <!-- Avatar -->
      <div style="width: 72px; height: 72px; background: #0D9F7A; border: 3px solid rgba(255,255,255,.15); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #fff; font-size: 22px; font-weight: 500; flex-shrink: 0;">
        {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
      </div>
      <!-- Info Tengah -->
      <div style="flex: 1;">
        <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap; margin-bottom: 6px;">
          <span style="color: #fff; font-size: 18px; font-weight: 500;">{{ auth()->user()->name }}</span>
          <span style="background: #0D9F7A; color: #fff; font-size: 11px; padding: 4px 12px; border-radius: 9999px; font-weight: 600;">Siswa</span>
        </div>
        <div style="display: flex; gap: 14px; font-size: 12px; color: #9FE1CB; flex-wrap: wrap;">
          <span style="display: flex; align-items: center; gap: 4px;">
            <i class="ti ti-mail"></i> {{ auth()->user()->email }}
          </span>
          <span style="display: flex; align-items: center; gap: 4px;">
            <i class="ti ti-school"></i> {{ auth()->user()->kelas ?? 'Umum' }}
          </span>
          <span style="display: flex; align-items: center; gap: 4px;">
            <i class="ti ti-phone"></i> {{ auth()->user()->phone ?? '-' }}
          </span>
        </div>
      </div>
    </div>
    
    <!-- Stat Kanan -->
    <div style="display: flex; align-items: center; gap: 16px; flex-shrink: 0;">
      <div style="text-align: center;">
        <div style="color: #fff; font-size: 16px; font-weight: 500;">{{ $totalBorrowings }}</div>
        <div style="color: #9ca3af; font-size: 10px; text-transform: uppercase; margin-top: 2px;">Total Pinjam</div>
      </div>
      <div style="width: 0.5px; height: 28px; background: rgba(255,255,255,.1);"></div>
      
      <div style="text-align: center;">
        <div style="color: #fff; font-size: 16px; font-weight: 500;">{{ $activeBorrowings }}</div>
        <div style="color: #9ca3af; font-size: 10px; text-transform: uppercase; margin-top: 2px;">Aktif</div>
      </div>
      <div style="width: 0.5px; height: 28px; background: rgba(255,255,255,.1);"></div>
      
      <div style="text-align: center;">
        <div style="color: #fff; font-size: 16px; font-weight: 500;">{{ $lateBorrowings }}</div>
        <div style="color: #9ca3af; font-size: 10px; text-transform: uppercase; margin-top: 2px;">Terlambat</div>
      </div>
    </div>
  </div>

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  GRID 2 KOLOM                                              --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 24px;">
    
    {{-- KOLOM KIRI — Card Informasi Akun (read-only) --}}
    <div style="flex: 1; min-width: 320px; background: #fff; border: 0.5px solid #e5e7eb; border-radius: 12px; padding: 20px; display: flex; flex-direction: column; gap: 16px;">
      <div style="display: flex; align-items: center; gap: 7px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 4px;">
        <i class="ti ti-user" style="color: #0D9F7A; font-size: 16px;"></i>
        <span style="color: #0A1628; font-size: 14px; font-weight: 500;">Informasi akun</span>
      </div>

      <!-- Field: Nama -->
      <div>
        <div style="font-size: 11px; font-weight: 500; color: #9ca3af; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 5px;">Nama Lengkap</div>
        <div style="background: #f8fafc; border: 0.5px solid #e5e7eb; border-radius: 8px; padding: 9px 12px; display: flex; align-items: center; gap: 8px;">
          <i class="ti ti-user" style="color: #9ca3af; font-size: 14px;"></i>
          <span style="font-size: 13px; color: #111827;">{{ auth()->user()->name }}</span>
        </div>
      </div>

      <!-- Field: Email -->
      <div>
        <div style="font-size: 11px; font-weight: 500; color: #9ca3af; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 5px;">Alamat Email</div>
        <div style="background: #f8fafc; border: 0.5px solid #e5e7eb; border-radius: 8px; padding: 9px 12px; display: flex; align-items: center; gap: 8px;">
          <i class="ti ti-mail" style="color: #9ca3af; font-size: 14px;"></i>
          <span style="font-size: 13px; color: #111827;">{{ auth()->user()->email }}</span>
        </div>
      </div>

      <!-- Field: Kelas -->
      <div>
        <div style="font-size: 11px; font-weight: 500; color: #9ca3af; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 5px;">Kelas</div>
        <div style="background: #f8fafc; border: 0.5px solid #e5e7eb; border-radius: 8px; padding: 9px 12px; display: flex; align-items: center; gap: 8px;">
          <i class="ti ti-school" style="color: #9ca3af; font-size: 14px;"></i>
          <span style="font-size: 13px; color: #111827;">{{ auth()->user()->kelas ?? '-' }}</span>
        </div>
      </div>

      <!-- Field: No HP -->
      <div>
        <div style="font-size: 11px; font-weight: 500; color: #9ca3af; text-transform: uppercase; letter-spacing: .05em; margin-bottom: 5px;">Nomor HP / WhatsApp</div>
        <div style="background: #f8fafc; border: 0.5px solid #e5e7eb; border-radius: 8px; padding: 9px 12px; display: flex; align-items: center; gap: 8px;">
          <i class="ti ti-phone" style="color: #9ca3af; font-size: 14px;"></i>
          <span style="font-size: 13px; color: #111827;">{{ auth()->user()->phone ?? '-' }}</span>
        </div>
      </div>
    </div>

    {{-- KOLOM KANAN — 2 card ditumpuk --}}
    <div style="flex: 1; min-width: 320px; display: flex; flex-direction: column; gap: 16px;">
      
      <!-- Card 1 — Edit Profil -->
      <div style="background: #fff; border: 0.5px solid #e5e7eb; border-radius: 12px; padding: 20px;">
        <div style="display: flex; align-items: center; gap: 7px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 16px;">
          <i class="ti ti-edit" style="color: #0D9F7A; font-size: 16px;"></i>
          <span style="color: #0A1628; font-size: 14px; font-weight: 500;">Edit profil</span>
        </div>

        <form method="POST" action="{{ route('user.profile.update') }}">
          @csrf
          @method('PATCH')
          
          <div style="margin-bottom: 12px;">
            <label style="font-size: 11px; font-weight: 600; color: #64748b;">Nama Lengkap</label>
            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                   style="font-size: 13px; background: #f8fafc; border: 0.5px solid #e5e7eb; border-radius: 8px; padding: 9px 12px; width: 100%; margin-top: 5px; box-sizing: border-box; outline: none; transition: border-color 0.2s;"
                   onfocus="this.style.borderColor='#0D9F7A'; this.style.backgroundColor='#fff';"
                   onblur="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='#f8fafc';">
          </div>

          <div style="margin-bottom: 12px;">
            <label style="font-size: 11px; font-weight: 600; color: #64748b;">Kelas</label>
            <input type="text" name="kelas" value="{{ old('kelas', auth()->user()->kelas) }}"
                   style="font-size: 13px; background: #f8fafc; border: 0.5px solid #e5e7eb; border-radius: 8px; padding: 9px 12px; width: 100%; margin-top: 5px; box-sizing: border-box; outline: none; transition: border-color 0.2s;"
                   onfocus="this.style.borderColor='#0D9F7A'; this.style.backgroundColor='#fff';"
                   onblur="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='#f8fafc';">
          </div>

          <div style="margin-bottom: 16px;">
            <label style="font-size: 11px; font-weight: 600; color: #64748b;">No. HP</label>
            <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}"
                   style="font-size: 13px; background: #f8fafc; border: 0.5px solid #e5e7eb; border-radius: 8px; padding: 9px 12px; width: 100%; margin-top: 5px; box-sizing: border-box; outline: none; transition: border-color 0.2s;"
                   onfocus="this.style.borderColor='#0D9F7A'; this.style.backgroundColor='#fff';"
                   onblur="this.style.borderColor='#e5e7eb'; this.style.backgroundColor='#f8fafc';">
          </div>

          <button type="submit" style="background: #0D9F7A; color: #fff; font-size: 13px; font-weight: 500; padding: 10px 22px; border-radius: 9px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
            <i class="ti ti-check"></i>
            <span>Simpan Perubahan</span>
          </button>
        </form>
      </div>

      <!-- Card 2 — Ganti Password -->
      <div style="background: #fff; border: 0.5px solid #fecaca; border-radius: 12px; padding: 20px;">
        <div style="display: flex; align-items: center; gap: 7px; border-bottom: 1px solid #fee2e2; padding-bottom: 12px; margin-bottom: 16px;">
          <i class="ti ti-lock" style="color: #dc2626; font-size: 16px;"></i>
          <span style="color: #dc2626; font-size: 14px; font-weight: 500;">Keamanan</span>
        </div>

        @if($errors->updatePassword->any())
          <div style="background: #fdf2f2; border: 0.5px solid #fde8e8; border-radius: 8px; padding: 10px 14px; margin-bottom: 14px;">
            @foreach($errors->updatePassword->all() as $err)
              <div style="color: #dc2626; font-size: 12px; font-weight: 500; margin-bottom: 2px;">{{ $err }}</div>
            @endforeach
          </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
          @csrf
          @method('PUT')

          <div style="margin-bottom: 12px;">
            <label style="font-size: 11px; font-weight: 600; color: #b91c1c;">Password Sekarang</label>
            <input type="password" name="current_password" required
                   style="font-size: 13px; background: #f8fafc; border: 0.5px solid #fecaca; border-radius: 8px; padding: 9px 12px; width: 100%; margin-top: 5px; box-sizing: border-box; outline: none; transition: border-color 0.2s;"
                   onfocus="this.style.borderColor='#dc2626'; this.style.backgroundColor='#fff';"
                   onblur="this.style.borderColor='#fecaca'; this.style.backgroundColor='#f8fafc';">
          </div>
          
          <div style="margin-bottom: 12px;">
            <label style="font-size: 11px; font-weight: 600; color: #b91c1c;">Password Baru</label>
            <input type="password" name="password" required
                   style="font-size: 13px; background: #f8fafc; border: 0.5px solid #fecaca; border-radius: 8px; padding: 9px 12px; width: 100%; margin-top: 5px; box-sizing: border-box; outline: none; transition: border-color 0.2s;"
                   onfocus="this.style.borderColor='#dc2626'; this.style.backgroundColor='#fff';"
                   onblur="this.style.borderColor='#fecaca'; this.style.backgroundColor='#f8fafc';">
          </div>

          <div style="margin-bottom: 16px;">
            <label style="font-size: 11px; font-weight: 600; color: #b91c1c;">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" required
                   style="font-size: 13px; background: #f8fafc; border: 0.5px solid #fecaca; border-radius: 8px; padding: 9px 12px; width: 100%; margin-top: 5px; box-sizing: border-box; outline: none; transition: border-color 0.2s;"
                   onfocus="this.style.borderColor='#dc2626'; this.style.backgroundColor='#fff';"
                   onblur="this.style.borderColor='#fecaca'; this.style.backgroundColor='#f8fafc';">
          </div>

          <button type="submit" style="background: #fff; color: #dc2626; border: 0.5px solid #fecaca; font-size: 12px; font-weight: 500; padding: 8px 16px; border-radius: 8px; cursor: pointer; width: 100%; display: inline-flex; align-items: center; justify-content: center; gap: 6px;">
            <i class="ti ti-lock"></i>
            <span>Ganti Password</span>
          </button>
        </form>
      </div>

    </div>

  </div>

  {{-- ═══════════════════════════════════════════════════════════ --}}
  {{--  CARD AKTIVITAS TERAKHIR                                   --}}
  {{-- ═══════════════════════════════════════════════════════════ --}}
  <div style="background: #fff; border: 0.5px solid #e5e7eb; border-radius: 12px; padding: 20px; margin-bottom: 40px;">
    <div style="display: flex; align-items: center; gap: 7px; border-bottom: 1px solid #f1f5f9; padding-bottom: 12px; margin-bottom: 12px;">
      <i class="ti ti-history" style="color: #0D9F7A; font-size: 16px;"></i>
      <span style="color: #0A1628; font-size: 14px; font-weight: 500;">Aktivitas peminjaman terakhir</span>
    </div>

    @foreach($recentBorrowings as $b)
      @php
        // Dot Color
        // borrowed/approved -> #0D9F7A, returned -> #185FA5, rejected/cancelled -> #9ca3af, late -> #dc2626
        $dotBg = '#0D9F7A';
        if ($b->status === 'returned') {
            $dotBg = '#185FA5';
        } elseif ($b->status === 'rejected' || $b->status === 'cancelled') {
            $dotBg = '#9ca3af';
        } elseif ($b->status === 'late') {
            $dotBg = '#dc2626';
        } elseif ($b->status === 'pending') {
            $dotBg = '#BA7517'; // Amber for pending
        }

        // Badge Status BG & Color
        // borrowed -> bg:#E1F5EE color:#0F6E56
        // returned -> bg:#E6F1FB color:#0C447C
        // rejected -> bg:#f1f5f9 color:#6b7280
        // pending  -> bg:#FAEEDA color:#633806
        // late     -> bg:#FCEBEB color:#791F1F
        $badgeBg = '#FAEEDA';
        $badgeColor = '#633806';
        $statusText = 'Menunggu';

        if ($b->status === 'borrowed') {
            $badgeBg = '#E1F5EE';
            $badgeColor = '#0F6E56';
            $statusText = 'Dipinjam';
        } elseif ($b->status === 'approved') {
            $badgeBg = '#E1F5EE';
            $badgeColor = '#0F6E56';
            $statusText = 'Disetujui';
        } elseif ($b->status === 'returned') {
            $badgeBg = '#E6F1FB';
            $badgeColor = '#0C447C';
            $statusText = 'Dikembalikan';
        } elseif ($b->status === 'rejected') {
            $badgeBg = '#f1f5f9';
            $badgeColor = '#6b7280';
            $statusText = 'Ditolak';
        } elseif ($b->status === 'cancelled') {
            $badgeBg = '#f1f5f9';
            $badgeColor = '#6b7280';
            $statusText = 'Batal';
        } elseif ($b->status === 'late') {
            $badgeBg = '#FCEBEB';
            $badgeColor = '#791F1F';
            $statusText = 'Terlambat';
        }
      @endphp
      <div style="display: flex; align-items: center; gap: 10px; padding: 12px 0; border-bottom: 0.5px solid #f1f5f9;">
        <!-- Dot -->
        <div style="width: 8px; height: 8px; background: {{ $dotBg }}; border-radius: 50%; flex-shrink: 0;"></div>
        
        <!-- Teks Tengah -->
        <div style="flex: 1; font-size: 12px; color: #374151;">
          Meminjam <strong>{{ $b->laptop->brand ?? 'N/A' }} {{ $b->laptop->model ?? '' }}</strong> untuk {{ $b->purpose }}
        </div>

        <!-- Kanan: Badge + Tanggal -->
        <div style="display: flex; align-items: center; gap: 12px; flex-shrink: 0;">
          <span style="background: {{ $badgeBg }}; color: {{ $badgeColor }}; font-size: 10px; font-weight: 600; padding: 3px 10px; border-radius: 9999px; text-transform: uppercase;">
            {{ $statusText }}
          </span>
          <span style="font-size: 11px; color: #9ca3af;">
            {{ $b->created_at->format('d M Y') }}
          </span>
        </div>
      </div>
    @endforeach

    @if($recentBorrowings->isEmpty())
      <div style="text-align: center; padding: 40px 20px;">
        <i class="ti ti-clipboard-list" style="font-size: 32px; color: #d1d5db; display: block; margin-bottom: 8px;"></i>
        <div style="font-size: 13px; color: #9ca3af;">Belum ada aktivitas peminjaman</div>
      </div>
    @endif
  </div>

</div>
@endsection
