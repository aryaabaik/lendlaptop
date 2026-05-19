@if (session('status'))
<div class="alert-ok">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
  @csrf
  
  {{-- Input Email dengan ikon amplop di kiri --}}
  <div class="field">
    <label for="email">Alamat Email</label>
    <div class="iw">
      <i class="ti ti-mail ic"></i>
      <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="username@unibi.ac.id" required autofocus autocomplete="username">
    </div>
    @error('email')
      <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
    @enderror
  </div>

  {{-- Input Password dengan ikon gembok + toggle show/hide --}}
  <div class="field">
    <label for="password">Password</label>
    <div class="iw">
      <i class="ti ti-lock ic"></i>
      <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
      <button type="button" class="eye" tabindex="-1" aria-label="Tampilkan Password">
        <i class="ti ti-eye"></i>
      </button>
    </div>
    @error('password')
      <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
    @enderror
  </div>

  {{-- Checkbox "Ingat saya" kiri + link "Lupa password?" kanan (text teal) --}}
  <div class="row-opt">
    <label class="rem" for="remember_me">
      <input type="checkbox" id="remember_me" name="remember">
      Ingat saya
    </label>
    @if (Route::has('password.request'))
      <a class="fgt" href="{{ route('password.request') }}">Lupa password?</a>
    @endif
  </div>

  {{-- Tombol submit: "Masuk ke Sistem" full-width bg-teal --}}
  <button type="submit" class="btn btn-primary" id="btn-login-submit">
    <i class="ti ti-login"></i> Masuk ke Sistem
  </button>

  {{-- Footer link: "Belum punya akun? Daftar" --}}
  <div class="flink">
    Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
  </div>
</form>
