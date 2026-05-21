<form method="POST" action="{{ route('register') }}">
  @csrf

  {{-- Nama Lengkap & NIM / Kelas --}}
  <div class="field-row">
    <div class="field">
      <label for="reg-name">Nama Lengkap</label>
      <div class="iw">
        <i class="ti ti-user ic"></i>
        <input type="text" id="reg-name" name="name" value="{{ old('name') }}" placeholder="Nama Anda" required autocomplete="name">
      </div>
      @error('name')
        <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
      @enderror
    </div>
    <div class="field" id="kelas-field">
      <label for="reg-kelas">NIM / Kelas</label>
      <div class="iw">
        <i class="ti ti-id-badge ic"></i>
        <input type="text" id="reg-kelas" name="kelas" value="{{ old('kelas') }}" placeholder="NIM Anda / NIDN">
      </div>
      @error('kelas')
        <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
      @enderror
    </div>
  </div>

  {{-- Email --}}
  <div class="field">
    <label for="reg-email">Alamat Email</label>
    <div class="iw">
      <i class="ti ti-mail ic"></i>
      <input type="email" id="reg-email" name="email" value="{{ old('email') }}" placeholder="username@unibi.ac.id" required autocomplete="username">
    </div>
    @error('email')
      <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
    @enderror
  </div>

  {{-- Password & Konfirmasi --}}
  <div class="field-row">
    <div class="field">
      <label for="reg-password">Password</label>
      <div class="iw">
        <i class="ti ti-lock ic"></i>
        <input type="password" id="reg-password" name="password" placeholder="Min. 8 karakter" required autocomplete="new-password">
        <button type="button" class="eye" tabindex="-1" aria-label="Tampilkan Password">
          <i class="ti ti-eye"></i>
        </button>
      </div>
      <div class="str-bar">
        <div class="str-seg"></div>
        <div class="str-seg"></div>
        <div class="str-seg"></div>
        <div class="str-seg"></div>
      </div>
      <div class="str-lbl" id="str-lbl"></div>
      @error('password')
        <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
      @enderror
    </div>
    
    <div class="field">
      <label for="reg-confirm">Konfirmasi Password</label>
      <div class="iw">
        <i class="ti ti-lock ic"></i>
        <input type="password" id="reg-confirm" name="password_confirmation" placeholder="Ulangi password" required autocomplete="new-password">
        <button type="button" class="eye" tabindex="-1" aria-label="Tampilkan Password">
          <i class="ti ti-eye"></i>
        </button>
      </div>
      @error('password_confirmation')
        <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
      @enderror
    </div>
  </div>

  {{-- Submit Button --}}
  <button type="submit" class="btn btn-primary" id="btn-register-submit">
    <i class="ti ti-user-plus"></i> Buat Akun Baru
  </button>

  {{-- Redirect --}}
  <div class="flink">
    Sudah punya akun? <a href="{{ route('login') }}">Masuk</a>
  </div>
</form>
