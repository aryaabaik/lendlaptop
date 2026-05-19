{{-- Steps --}}
<div class="steps">
  <div class="snum {{ session('status') ? 'done' : 'active' }}" id="s1">1</div>
  <span class="slbl {{ !session('status') ? 'active' : '' }}">Input Email</span>
  <div class="sline {{ session('status') ? 'done' : '' }}"></div>
  <div class="snum {{ session('status') ? 'active' : 'idle' }}" id="s2">2</div>
  <span class="slbl {{ session('status') ? 'active' : '' }}">Konfirmasi</span>
</div>

@if(session('status'))
<div class="success-box" style="background: rgba(13, 159, 122, 0.05); border: 1px solid rgba(13, 159, 122, 0.2); border-radius: 12px; padding: 20px; margin-bottom: 20px;">
  <div class="success-ico" style="background: rgba(13, 159, 122, 0.1); border-color: rgba(13, 159, 122, 0.3);">
    <i class="ti ti-mail-fast" style="font-size: 2rem; color: var(--teal);"></i>
  </div>
  <h3 style="color: #0b7a5e;">Email Terkirim!</h3>
  <p style="color: #0d9f7a; font-weight: 500;">{{ session('status') }}</p>
  <p style="margin-top: 10px; font-size: 0.8rem;">Silakan periksa inbox atau folder spam email Anda.</p>
</div>
@endif

@if(!session('status'))
<form method="POST" action="{{ route('password.email') }}">
  @csrf
  <div class="field">
    <label for="reset-email">Alamat Email</label>
    <div class="iw">
      <i class="ti ti-mail ic"></i>
      <input type="email" id="reset-email" name="email" value="{{ old('email') }}" placeholder="username@unibi.ac.id" required autofocus>
    </div>
    @error('email')
      <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
    @enderror
  </div>
  
  <button type="submit" class="btn btn-primary" id="btn-reset-submit">
    <i class="ti ti-mail-forward"></i> Kirim Link Reset
  </button>
</form>
@endif

<div class="flink" style="margin-top:20px">
  <a href="{{ route('login') }}"><i class="ti ti-arrow-back-up"></i> Kembali ke Masuk</a>
</div>
