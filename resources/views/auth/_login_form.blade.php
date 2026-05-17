@if (session('status'))
<div class="alert-ok">{{ session('status') }}</div>
@endif

<form method="POST" action="{{ route('login') }}">
@csrf
<div class="field">
  <label for="email">Email</label>
  <div class="iw">
    <svg class="ic" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
    <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="email@unibi.ac.id" required autofocus autocomplete="username">
  </div>
  @error('email')<p class="ferr">{{ $message }}</p>@enderror
</div>
<div class="field">
  <label for="password">Password</label>
  <div class="iw">
    <svg class="ic" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
    <input type="password" id="password" name="password" placeholder="••••••••" required autocomplete="current-password">
    <button type="button" class="eye" tabindex="-1"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
  </div>
  @error('password')<p class="ferr">{{ $message }}</p>@enderror
</div>
<div class="row-opt">
  <label class="rem" for="remember_me"><input type="checkbox" id="remember_me" name="remember"> Ingat saya</label>
  @if (Route::has('password.request'))
  <a class="fgt" href="{{ route('password.request') }}" onclick="event.preventDefault();switchTab('reset')">Lupa password?</a>
  @endif
</div>
<button type="submit" class="btn btn-primary">Masuk ke Sistem</button>
<div class="flink">Belum punya akun? <a href="{{ route('register') }}" onclick="event.preventDefault();switchTab('register')">Daftar</a></div>
</form>
