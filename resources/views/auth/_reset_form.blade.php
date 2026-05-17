<!-- Steps -->
<div class="steps">
  <div class="snum {{ session('status') ? 'done' : 'active' }}" id="s1">1</div>
  <span class="slbl {{ !session('status') ? 'active' : '' }}">Input Email</span>
  <div class="sline {{ session('status') ? 'done' : '' }}"></div>
  <div class="snum {{ session('status') ? 'active' : 'idle' }}" id="s2">2</div>
  <span class="slbl {{ session('status') ? 'active' : '' }}">Konfirmasi</span>
</div>

@if(session('status'))
<div class="success-box">
  <div class="success-ico">
    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
  </div>
  <h3>Email Terkirim!</h3>
  <p>Link reset password telah dikirim ke email Anda. Periksa inbox atau folder spam.</p>
  <br>
  <button type="button" class="btn btn-primary" onclick="switchTab('login')">Kembali ke Login</button>
</div>
@else
<form method="POST" action="{{ route('password.email') }}">
@csrf
<div class="field">
  <label for="reset-email">Alamat Email</label>
  <div class="iw">
    <svg class="ic" width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
    <input type="email" id="reset-email" name="email" value="{{ old('email') }}" placeholder="email@unibi.ac.id" required autofocus>
  </div>
  @error('email')<p class="ferr">{{ $message }}</p>@enderror
</div>
<button type="submit" class="btn btn-primary">Kirim Link Reset</button>
</form>
@endif

<div class="flink" style="margin-top:14px">Ingat password? <a href="{{ route('login') }}" onclick="event.preventDefault();switchTab('login')">Masuk</a></div>
