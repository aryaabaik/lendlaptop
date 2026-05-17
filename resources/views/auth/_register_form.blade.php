<form method="POST" action="{{ route('register') }}">
@csrf
<div class="field"><label>Daftar sebagai</label>
  <div class="roles">
    <label class="role-card selected" data-group="role" data-val="user">
      <input type="radio" name="role" value="user" checked>
      <div class="role-icon"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
      <div class="role-name">Peminjam</div>
      <div class="role-desc">Mahasiswa / Dosen</div>
    </label>
    <label class="role-card" data-group="role" data-val="admin">
      <input type="radio" name="role" value="admin">
      <div class="role-icon"><svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
      <div class="role-name">Admin</div>
      <div class="role-desc">Pengelola sistem</div>
    </label>
  </div>
</div>
<div class="field-row">
  <div class="field">
    <label for="reg-name">Nama Lengkap</label>
    <div class="iw">
      <svg class="ic" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      <input type="text" id="reg-name" name="name" value="{{ old('name') }}" placeholder="Nama kamu" required autocomplete="name">
    </div>
    @error('name')<p class="ferr">{{ $message }}</p>@enderror
  </div>
  <div class="field" id="kelas-field">
    <label for="reg-kelas">NIM / Kelas</label>
    <div class="iw">
      <svg class="ic" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
      <input type="text" id="reg-kelas" name="kelas" value="{{ old('kelas') }}" placeholder="2024SI001">
    </div>
  </div>
</div>
<div class="field">
  <label for="reg-email">Email</label>
  <div class="iw">
    <svg class="ic" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
    <input type="email" id="reg-email" name="email" value="{{ old('email') }}" placeholder="email@unibi.ac.id" required autocomplete="username">
  </div>
  @error('email')<p class="ferr">{{ $message }}</p>@enderror
</div>
<div class="field-row">
  <div class="field">
    <label for="reg-password">Password</label>
    <div class="iw">
      <svg class="ic" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      <input type="password" id="reg-password" name="password" placeholder="Min. 8 karakter" required autocomplete="new-password">
      <button type="button" class="eye" tabindex="-1"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
    </div>
    <div class="str-bar"><div class="str-seg"></div><div class="str-seg"></div><div class="str-seg"></div><div class="str-seg"></div></div>
    <div class="str-lbl" id="str-lbl"></div>
    @error('password')<p class="ferr">{{ $message }}</p>@enderror
  </div>
  <div class="field">
    <label for="reg-confirm">Konfirmasi</label>
    <div class="iw">
      <svg class="ic" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
      <input type="password" id="reg-confirm" name="password_confirmation" placeholder="Ulangi password" required autocomplete="new-password">
      <button type="button" class="eye" tabindex="-1"><svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg></button>
    </div>
    @error('password_confirmation')<p class="ferr">{{ $message }}</p>@enderror
  </div>
</div>
<button type="submit" class="btn btn-primary">Buat Akun</button>
<div class="flink">Sudah punya akun? <a href="{{ route('login') }}" onclick="event.preventDefault();switchTab('login')">Masuk</a></div>
</form>
