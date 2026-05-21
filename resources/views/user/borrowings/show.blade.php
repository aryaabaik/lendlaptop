@extends('layouts.app')

@section('title', 'Detail Peminjaman #' . $borrowing->id)

@section('content')

{{-- ─── Container ──────────────────────────────────────────────────── --}}
<div style="max-width: 680px; margin: 0 auto; padding-bottom: 48px;">

  {{-- Back link --}}
  <a href="{{ route('user.borrowings.index') }}"
     style="display: inline-flex; align-items: center; gap: 6px;
            font-size: 0.82rem; font-weight: 600; color: #64748b;
            text-decoration: none; margin-bottom: 20px;">
    <i class="ti ti-arrow-left"></i> Kembali ke Daftar Peminjaman
  </a>

  {{-- ── CARD UTAMA ──────────────────────────────────────────────── --}}
  <div style="background: #fff; border-radius: 0.75rem; border: 1px solid #f3f4f6;
              box-shadow: 0 1px 4px rgba(0,0,0,.04); overflow: hidden;">

    {{-- Card Header --}}
    <div style="padding: 20px 24px; background: #f9fafb; border-bottom: 1px solid #f3f4f6;
                display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;">
      <h1 style="font-size: 1rem; font-weight: 700; color: #0A1628; margin: 0;">
        Peminjaman #{{ $borrowing->id }}
      </h1>

      {{-- Badge status --}}
      @php
        $badgeMap = [
          'pending'   => ['bg' => 'rgba(245,158,11,.12)',  'color' => '#b45309', 'label' => 'Menunggu'],
          'approved'  => ['bg' => 'rgba(59,130,246,.12)',  'color' => '#1d4ed8', 'label' => 'Disetujui'],
          'borrowed'  => ['bg' => 'rgba(13,159,122,.12)',  'color' => '#0D9F7A', 'label' => 'Dipinjam'],
          'returned'  => ['bg' => 'rgba(16,185,129,.12)',  'color' => '#047857', 'label' => 'Dikembalikan'],
          'rejected'  => ['bg' => 'rgba(239,68,68,.12)',   'color' => '#b91c1c', 'label' => 'Ditolak'],
          'cancelled' => ['bg' => 'rgba(239,68,68,.12)',   'color' => '#b91c1c', 'label' => 'Dibatalkan'],
        ];
        $badge = $badgeMap[$borrowing->status] ?? ['bg' => '#e5e7eb', 'color' => '#374151', 'label' => ucfirst($borrowing->status)];
      @endphp
      <span style="display: inline-flex; align-items: center; padding: 4px 12px;
                   border-radius: 9999px; font-size: 0.72rem; font-weight: 700;
                   text-transform: uppercase; letter-spacing: .04em;
                   background: {{ $badge['bg'] }}; color: {{ $badge['color'] }};">
        {{ $badge['label'] }}
      </span>
    </div>

    {{-- Card Body --}}
    <div style="padding: 28px 24px;">

      {{-- Grid info 2-kolom --}}
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">

        {{-- Laptop --}}
        <div style="display: flex; flex-direction: column; gap: 5px;">
          <span style="font-size: 0.68rem; font-weight: 700; color: #64748b;
                       text-transform: uppercase; letter-spacing: .05em;">Laptop</span>
          <div style="display: flex; align-items: center; gap: 10px;">
            <div style="width: 36px; height: 36px; border-radius: 8px; flex-shrink: 0;
                        background: rgba(13,159,122,.1); color: #0D9F7A;
                        display: flex; align-items: center; justify-content: center; font-size: 1.1rem;">
              <i class="ti ti-device-laptop"></i>
            </div>
            <div>
              <div style="font-weight: 700; font-size: 0.88rem; color: #1e293b;">
                {{ $borrowing->laptop->brand ?? 'N/A' }} {{ $borrowing->laptop->model ?? '' }}
              </div>
              @if($borrowing->laptop)
                <div style="font-size: 0.72rem; color: #64748b; margin-top: 1px;">
                  {{ $borrowing->laptop->asset_code ?? '' }}
                </div>
              @endif
            </div>
          </div>
        </div>

        {{-- Peminjam --}}
        <div style="display: flex; flex-direction: column; gap: 5px;">
          <span style="font-size: 0.68rem; font-weight: 700; color: #64748b;
                       text-transform: uppercase; letter-spacing: .05em;">Nama Peminjam</span>
          <div style="display: flex; align-items: center; gap: 10px;">
            <div style="width: 36px; height: 36px; border-radius: 50%; flex-shrink: 0;
                        background: rgba(13,159,122,.1); color: #0D9F7A;
                        display: flex; align-items: center; justify-content: center;
                        font-weight: 700; font-size: 0.85rem; border: 1px solid rgba(13,159,122,.2);">
              {{ strtoupper(substr($borrowing->borrower_name ?? 'U', 0, 2)) }}
            </div>
            <span style="font-weight: 600; font-size: 0.88rem; color: #1e293b;">
              {{ $borrowing->borrower_name ?? 'N/A' }}
            </span>
          </div>
        </div>

        {{-- Keperluan (full width) --}}
        <div style="grid-column: 1 / -1; display: flex; flex-direction: column; gap: 5px;">
          <span style="font-size: 0.68rem; font-weight: 700; color: #64748b;
                       text-transform: uppercase; letter-spacing: .05em;">Keperluan</span>
          <p style="font-size: 0.88rem; color: #1e293b; margin: 0; line-height: 1.5;">
            {{ $borrowing->purpose }}
          </p>
        </div>

        {{-- Tanggal Pinjam → Kembali (full width) --}}
        <div style="grid-column: 1 / -1; display: flex; flex-direction: column; gap: 8px;">
          <span style="font-size: 0.68rem; font-weight: 700; color: #64748b;
                       text-transform: uppercase; letter-spacing: .05em;">Jangka Waktu</span>
          <div style="display: inline-flex; align-items: center; gap: 14px;
                      background: #f9fafb; border: 1px solid #e5e7eb;
                      border-radius: 8px; padding: 10px 16px; width: fit-content;">
            <div style="display: flex; flex-direction: column;">
              <span style="font-size: 0.62rem; color: #64748b; font-weight: 600;
                           text-transform: uppercase; margin-bottom: 2px;">Pinjam</span>
              <span style="font-weight: 700; color: #1e293b; font-size: 0.88rem;">
                {{ $borrowing->borrow_date->format('d M Y') }}
              </span>
            </div>
            <i class="ti ti-arrow-narrow-right" style="color: #0D9F7A; font-size: 1.2rem;"></i>
            <div style="display: flex; flex-direction: column;">
              <span style="font-size: 0.62rem; color: #64748b; font-weight: 600;
                           text-transform: uppercase; margin-bottom: 2px;">Kembali</span>
              <span style="font-weight: 700; font-size: 0.88rem;
                           color: {{ $borrowing->isLate() ? '#EF4444' : '#1e293b' }};">
                {{ $borrowing->return_date->format('d M Y') }}
                @if($borrowing->isLate())
                  <i class="ti ti-alert-triangle" style="font-size: 0.9rem;"></i>
                @endif
              </span>
            </div>
          </div>
        </div>

      </div>{{-- /grid --}}

      {{-- ════════════════════════════════════════════════════════
           BLOK STATUS DENDA / KETERLAMBATAN (setelah bagian tanggal)
           ════════════════════════════════════════════════════════ --}}
      @if($borrowing->isLate())

        {{-- ── TERLAMBAT ── --}}
        <div style="margin-top: 24px; border-radius: 10px; overflow: hidden;
                    border: 1.5px solid #fecaca;">

          {{-- Header merah --}}
          <div style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
                      padding: 14px 20px; display: flex; align-items: center; gap: 10px;">
            <i class="ti ti-clock-exclamation" style="font-size: 1.3rem; color: #fff;"></i>
            <span style="font-weight: 700; color: #fff; font-size: 0.95rem;">
              Peminjaman Anda Terlambat {{ $borrowing->late_days }} Hari
            </span>
          </div>

          {{-- Body info denda --}}
          <div style="background: #fff5f5; padding: 18px 20px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">

              <div style="background: #fff; border: 1px solid #fecaca; border-radius: 8px; padding: 12px 14px;">
                <div style="font-size: 0.65rem; font-weight: 700; color: #f87171;
                             text-transform: uppercase; letter-spacing: .05em; margin-bottom: 4px;">
                  Jatuh tempo
                </div>
                <div style="font-weight: 700; color: #991b1b; font-size: 0.9rem;">
                  {{ $borrowing->return_date->format('d M Y') }}
                </div>
              </div>

              <div style="background: #fff; border: 1px solid #fecaca; border-radius: 8px; padding: 12px 14px;">
                <div style="font-size: 0.65rem; font-weight: 700; color: #f87171;
                             text-transform: uppercase; letter-spacing: .05em; margin-bottom: 4px;">
                  Hari terlambat
                </div>
                <div style="font-weight: 700; color: #991b1b; font-size: 0.9rem;">
                  {{ $borrowing->late_days }} hari
                </div>
              </div>

              <div style="background: #fff; border: 1px solid #fecaca; border-radius: 8px; padding: 12px 14px;">
                <div style="font-size: 0.65rem; font-weight: 700; color: #f87171;
                             text-transform: uppercase; letter-spacing: .05em; margin-bottom: 4px;">
                  Tarif denda
                </div>
                <div style="font-weight: 700; color: #991b1b; font-size: 0.9rem;">
                  Rp 10.000 / hari
                </div>
              </div>

              <div style="background: #fff; border: 1px solid #fecaca; border-radius: 8px; padding: 12px 14px;">
                <div style="font-size: 0.65rem; font-weight: 700; color: #f87171;
                             text-transform: uppercase; letter-spacing: .05em; margin-bottom: 4px;">
                  Total denda estimasi
                </div>
                <div style="font-weight: 700; color: #991b1b; font-size: 0.9rem;">
                  {{ $borrowing->formatted_fine }}
                </div>
              </div>

            </div>

            {{-- Peringatan --}}
            <div style="margin-top: 14px; background: #fee2e2; border-radius: 8px;
                        padding: 10px 14px; font-size: 0.8rem; color: #991b1b;
                        font-weight: 600; display: flex; align-items: center; gap: 8px;">
              <i class="ti ti-alert-triangle" style="font-size: 1rem; flex-shrink: 0;"></i>
              Segera kembalikan laptop ke admin. Denda bertambah setiap hari.
            </div>
          </div>
        </div>

      @elseif(in_array($borrowing->status, ['borrowed', 'approved']))

        {{-- ── TEPAT WAKTU ── --}}
        <div style="margin-top: 24px; background: rgba(13,159,122,.06);
                    border: 1.5px solid rgba(13,159,122,.2); border-radius: 10px;
                    padding: 14px 20px; display: flex; align-items: center; gap: 14px;">
          <div style="width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0;
                      background: rgba(13,159,122,.15); color: #0D9F7A;
                      display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
            <i class="ti ti-circle-check"></i>
          </div>
          <div>
            <div style="font-weight: 700; color: #0D9F7A; font-size: 0.9rem;">
              Tepat Waktu
            </div>
            <div style="font-size: 0.8rem; color: #64748b; margin-top: 2px;">
              Sisa {{ now()->diffInDays($borrowing->return_date) }} hari
              &middot; Kembalikan sebelum {{ $borrowing->return_date->format('d M Y') }}
            </div>
          </div>
        </div>

      @elseif($borrowing->status === 'returned' && $borrowing->fine > 0)

        {{-- ── SUDAH KEMBALI, ADA DENDA TERCATAT ── --}}
        <div style="margin-top: 24px; background: rgba(245,158,11,.06);
                    border: 1.5px solid rgba(245,158,11,.25); border-radius: 10px;
                    padding: 14px 20px; display: flex; align-items: center; gap: 14px;">
          <div style="width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0;
                      background: rgba(245,158,11,.15); color: #D97706;
                      display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">
            <i class="ti ti-receipt"></i>
          </div>
          <div>
            <div style="font-weight: 700; color: #D97706; font-size: 0.9rem;">
              Denda yang dibayarkan
            </div>
            <div style="font-size: 0.88rem; font-weight: 700; color: #1e293b; margin-top: 2px;">
              Rp {{ number_format($borrowing->fine, 0, ',', '.') }}
            </div>
          </div>
        </div>

      @endif
      {{-- ═══ END BLOK STATUS DENDA ═══ --}}

      {{-- Catatan Admin (jika ada) --}}
      @if($borrowing->admin_note)
        <div style="margin-top: 24px; padding: 14px 18px;
                    background: #f8fafc; border-left: 4px solid #cbd5e1;
                    border-radius: 0 8px 8px 0;">
          <div style="font-size: 0.65rem; font-weight: 700; color: #64748b;
                      text-transform: uppercase; letter-spacing: .05em; margin-bottom: 4px;">
            Catatan Admin
          </div>
          <p style="font-size: 0.84rem; font-style: italic; color: #475569;
                    line-height: 1.55; margin: 0;">
            "{{ $borrowing->admin_note }}"
          </p>
        </div>
      @endif

    </div>{{-- /card body --}}

    {{-- Card Footer: tombol kembali --}}
    <div style="padding: 16px 24px; background: #f9fafb; border-top: 1px solid #f3f4f6;
                display: flex; justify-content: flex-end;">
      <a href="{{ route('user.borrowings.index') }}"
         style="display: inline-flex; align-items: center; gap: 6px;
                padding: 9px 20px; border-radius: 0.5rem; font-size: 0.82rem;
                font-weight: 600; color: #64748b; text-decoration: none;
                border: 1px solid #e2e8f0; background: #fff;
                transition: background .2s;">
        <i class="ti ti-list"></i> Kembali ke Daftar
      </a>
    </div>

  </div>{{-- /card --}}

</div>{{-- /container --}}

@endsection
