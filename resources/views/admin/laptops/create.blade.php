@extends('layouts.admin')

@section('title', isset($laptop) ? 'Edit Laptop' : 'Tambah Laptop')
@section('page_title', isset($laptop) ? 'Edit Laptop' : 'Tambah Laptop Baru')

@section('breadcrumb')
  <a href="{{ route('admin.laptops.index') }}">Laptop</a>
  <span>/</span>
  <span>{{ isset($laptop) ? 'Edit' : 'Tambah' }}</span>
@endsection

@section('content')
<style>
/* ─── CREATE/EDIT FORM STYLE ───────────────────────────────── */
.form-container {
  max-width: 768px; /* max-w-3xl */
  margin: 0 auto;
}
.form-card {
  background: #fff;
  border-radius: 1rem;
  border: 1px solid #f1f5f9;
  box-shadow: 0 1px 3px rgba(0,0,0,.04), 0 1px 2px rgba(0,0,0,.02);
  padding: 32px;
}
.form-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
  margin-bottom: 24px;
}
@media(max-width: 767px) {
  .form-grid {
    grid-template-columns: 1fr;
    gap: 16px;
  }
}

/* Custom form fields with left icon */
.f-group {
  margin-bottom: 4px;
}
.f-label {
  display: block;
  font-size: .8rem;
  font-weight: 600;
  color: #475569;
  margin-bottom: 6px;
}
.f-label span {
  color: var(--red);
}
.f-input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}
.f-input-wrapper i {
  position: absolute;
  left: 14px;
  color: #94a3b8;
  font-size: 1.1rem;
  pointer-events: none;
}
.f-input {
  width: 100%;
  background: #f8fafc;
  border: 1px solid #cbd5e1;
  border-radius: 10px;
  padding: 11px 16px 11px 42px;
  font-family: 'Inter', sans-serif;
  font-size: .85rem;
  color: var(--text);
  outline: none;
  transition: all .2s ease;
}
.f-input:focus {
  border-color: var(--teal);
  background: #fff;
  box-shadow: 0 0 0 4px rgba(13,159,122,.15);
}
.f-select {
  width: 100%;
  background: #f8fafc;
  border: 1px solid #cbd5e1;
  border-radius: 10px;
  padding: 11px 16px;
  font-family: 'Inter', sans-serif;
  font-size: .85rem;
  color: var(--text);
  outline: none;
  cursor: pointer;
  transition: all .2s ease;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2394a3b8' stroke-width='2.5'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19.5 8.25l-7.5 7.5-7.5-7.5'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 14px center;
  background-size: 14px;
}
.f-select:focus {
  border-color: var(--teal);
  background-color: #fff;
}

/* Photo Upload Area & Preview */
.upload-area {
  border: 2px dashed #cbd5e1;
  border-radius: 12px;
  padding: 24px;
  text-align: center;
  background: #f8fafc;
  cursor: pointer;
  transition: all .2s ease;
  position: relative;
}
.upload-area:hover {
  border-color: var(--teal);
  background: rgba(13,159,122,.02);
}
.upload-icon {
  font-size: 2.2rem;
  color: #94a3b8;
  margin-bottom: 10px;
  transition: color .2s;
}
.upload-area:hover .upload-icon {
  color: var(--teal);
}
.upload-text {
  font-size: .82rem;
  color: var(--muted);
  font-weight: 500;
}
.upload-text strong {
  color: var(--teal);
}
.file-input-hidden {
  position: absolute;
  inset: 0;
  opacity: 0;
  cursor: pointer;
}

/* Image Preview Block */
.preview-block {
  margin-top: 16px;
  display: flex;
  align-items: center;
  gap: 16px;
  background: #f8fafc;
  border: 1px solid #e2e8f0;
  border-radius: 10px;
  padding: 12px;
}
.preview-img {
  width: 64px;
  height: 64px;
  border-radius: 8px;
  object-fit: cover;
  border: 1px solid #cbd5e1;
}
.preview-info {
  display: flex;
  flex-direction: column;
  gap: 2px;
}
.preview-name {
  font-size: .8rem;
  font-weight: 600;
  color: var(--text);
  max-width: 320px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}
.preview-size {
  font-size: .72rem;
  color: var(--muted);
}

/* Error validation text */
.ferr {
  margin-top: 6px;
  font-size: .74rem;
  font-weight: 500;
  color: var(--red);
  display: flex;
  align-items: center;
  gap: 4px;
}

/* Form Action Buttons */
.form-actions {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-top: 10px;
  border-top: 1px solid #f1f5f9;
  padding-top: 24px;
}
</style>

<div class="form-container">
  <div class="form-card">
    
    <form method="POST" action="{{ isset($laptop) ? route('admin.laptops.update', $laptop->id) : route('admin.laptops.store') }}" enctype="multipart/form-data">
      @csrf
      @if(isset($laptop))
        @method('PUT')
      @endif

      <div class="form-grid">
        
        {{-- Kode Laptop --}}
        <div class="f-group">
          <label class="f-label" for="code">Kode Laptop (Otomatis) <span>*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-hash"></i>
            <input type="text" id="code" name="code" class="f-input" value="{{ old('code', $laptop->code ?? $nextCode ?? '') }}" placeholder="LP-001" required 
              readonly style="background:#f1f5f9;color:#64748b;pointer-events:none;">
          </div>
          @error('code')
            <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
          @enderror
        </div>

        {{-- Kategori --}}
        <div class="f-group">
          <label class="f-label" for="category_id">Kategori <span>*</span></label>
          <select id="category_id" name="category_id" class="f-select" required>
            <option value="">Pilih Kategori</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id', $laptop->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
              </option>
            @endforeach
          </select>
          @error('category_id')
            <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
          @enderror
        </div>

        {{-- Merk --}}
        <div class="f-group">
          <label class="f-label" for="brand">Merk <span>*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-building"></i>
            <input type="text" id="brand" name="brand" class="f-input" value="{{ old('brand', $laptop->brand ?? '') }}" placeholder="ASUS / Lenovo / HP" required>
          </div>
          @error('brand')
            <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
          @enderror
        </div>

        {{-- Model --}}
        <div class="f-group">
          <label class="f-label" for="model">Model / Tipe <span>*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-device-laptop"></i>
            <input type="text" id="model" name="model" class="f-input" value="{{ old('model', $laptop->model ?? '') }}" placeholder="ThinkPad L14 / VivoBook" required>
          </div>
          @error('model')
            <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
          @enderror
        </div>

        {{-- Prosesor --}}
        <div class="f-group">
          <label class="f-label" for="processor">Prosesor <span>*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-cpu"></i>
            <input type="text" id="processor" name="processor" class="f-input" value="{{ old('processor', $laptop->processor ?? '') }}" placeholder="Intel Core i5-1135G7 / AMD Ryzen 5" required>
          </div>
          @error('processor')
            <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
          @enderror
        </div>

        {{-- RAM --}}
        <div class="f-group">
          <label class="f-label" for="ram">RAM (GB) <span>*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-database"></i>
            <input type="number" id="ram" name="ram" class="f-input" value="{{ old('ram', $laptop->ram ?? '') }}" placeholder="8" required min="1">
          </div>
          @error('ram')
            <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
          @enderror
        </div>

        {{-- Storage --}}
        <div class="f-group">
          <label class="f-label" for="storage">Storage / Penyimpanan <span>*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-server"></i>
            <input type="text" id="storage" name="storage" class="f-input" value="{{ old('storage', $laptop->storage ?? '') }}" placeholder="512GB SSD PCIe NVMe" required>
          </div>
          @error('storage')
            <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
          @enderror
        </div>

        {{-- VGA --}}
        <div class="f-group">
          <label class="f-label" for="vga">VGA Graphics</label>
          <div class="f-input-wrapper">
            <i class="ti ti-device-desktop"></i>
            <input type="text" id="vga" name="vga" class="f-input" value="{{ old('vga', $laptop->vga ?? '') }}" placeholder="Intel Iris Xe / NVIDIA MX450 (Opsional)">
          </div>
          @error('vga')
            <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
          @enderror
        </div>

        {{-- Serial Number --}}
        <div class="f-group">
          <label class="f-label" for="serial_number">Nomor Seri (S/N) <span>*</span></label>
          <div class="f-input-wrapper">
            <i class="ti ti-barcode"></i>
            <input type="text" id="serial_number" name="serial_number" class="f-input" value="{{ old('serial_number', $laptop->serial_number ?? '') }}" placeholder="SN-8972136X" required
              {{ isset($laptop) ? 'readonly style=background:#f1f5f9;color:#64748b;pointer-events:none;' : '' }}>
          </div>
          @error('serial_number')
            <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
          @enderror
        </div>

        {{-- Kondisi --}}
        <div class="f-group">
          <label class="f-label" for="condition">Kondisi Fisik <span>*</span></label>
          <select id="condition" name="condition" class="f-select" required>
            <option value="baik" {{ old('condition', $laptop->condition ?? '') === 'baik' ? 'selected' : '' }}>Baik</option>
            <option value="rusak_ringan" {{ old('condition', $laptop->condition ?? '') === 'rusak_ringan' ? 'selected' : '' }}>Rusak Ringan</option>
            <option value="rusak_berat" {{ old('condition', $laptop->condition ?? '') === 'rusak_berat' ? 'selected' : '' }}>Rusak Berat</option>
          </select>
          @error('condition')
            <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
          @enderror
        </div>

        {{-- Status --}}
        <div class="f-group">
          <label class="f-label" for="status">Status <span>*</span></label>
          <select id="status" name="status" class="f-select" required>
            <option value="tersedia" {{ old('status', $laptop->status ?? '') === 'tersedia' ? 'selected' : '' }}>Tersedia</option>
            <option value="dipinjam" {{ old('status', $laptop->status ?? '') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
            <option value="maintenance" {{ old('status', $laptop->status ?? '') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
            <option value="rusak" {{ old('status', $laptop->status ?? '') === 'rusak' ? 'selected' : '' }}>Rusak</option>
          </select>
          @error('status')
            <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
          @enderror
        </div>

      </div>

      {{-- Upload Cover Laptop --}}
      <div class="f-group" style="margin-bottom: 24px;">
        <label class="f-label">Upload Foto Laptop</label>
        <div class="upload-area" id="drop-area">
          <i class="ti ti-cloud-upload upload-icon"></i>
          <p class="upload-text">Tarik & letakkan foto di sini, atau <strong>Pilih File</strong></p>
          <p class="upload-text" style="font-size: 0.72rem; margin-top: 4px; color: #94a3b8;">Format file: JPG, PNG, WEBP (Maks. 2MB)</p>
          <input type="file" name="image" id="file-input" class="file-input-hidden" accept="image/*" onchange="handleFileSelect(event)">
        </div>
        @error('image')
          <p class="ferr"><i class="ti ti-alert-circle"></i> {{ $message }}</p>
        @enderror

        {{-- Container Preview --}}
        <div id="preview-container" style="display: {{ isset($laptop) && $laptop->image ? 'flex' : 'none' }};">
          <div class="preview-block">
            <img id="preview-img-el" class="preview-img" src="{{ isset($laptop) && $laptop->image ? asset('storage/' . $laptop->image) : '' }}" alt="Preview foto laptop">
            <div class="preview-info">
              <span id="preview-filename" class="preview-name">{{ isset($laptop) && $laptop->image ? basename($laptop->image) : 'Namafile.jpg' }}</span>
              <span id="preview-filesize" class="preview-size">{{ isset($laptop) && $laptop->image ? 'Foto Tersimpan' : 'File terunggah' }}</span>
            </div>
          </div>
        </div>
      </div>

      {{-- Actions Buttons --}}
      <div class="form-actions">
        <button type="submit" class="btn btn-primary">
          <i class="ti ti-device-floppy"></i> {{ isset($laptop) ? 'Simpan Perubahan' : 'Simpan Laptop' }}
        </button>
        <a href="{{ route('admin.laptops.index') }}" class="btn btn-secondary">
          Batal
        </a>
      </div>

    </form>

  </div>
</div>

@push('scripts')
<script>
// Handle file selection preview
function handleFileSelect(event) {
  var input = event.target;
  var files = input.files;
  if (files && files[0]) {
    var reader = new FileReader();
    reader.onload = function(e) {
      var previewContainer = document.getElementById('preview-container');
      var previewImg = document.getElementById('preview-img-el');
      var previewName = document.getElementById('preview-filename');
      var previewSize = document.getElementById('preview-filesize');
      
      previewImg.src = e.target.result;
      previewName.textContent = files[0].name;
      
      // Calculate file size in KB/MB
      var size = files[0].size;
      if (size > 1024 * 1024) {
        previewSize.textContent = (size / (1024 * 1024)).toFixed(2) + ' MB';
      } else {
        previewSize.textContent = (size / 1024).toFixed(2) + ' KB';
      }
      
      previewContainer.style.display = 'flex';
    }
    reader.readAsDataURL(files[0]);
  }
}

// Drag & drop listeners
var dropArea = document.getElementById('drop-area');
['dragenter', 'dragover'].forEach(eventName => {
  dropArea.addEventListener(eventName, e => {
    e.preventDefault();
    dropArea.style.borderColor = 'var(--teal)';
    dropArea.style.background = 'rgba(13, 159, 122, 0.05)';
  }, false);
});
['dragleave', 'drop'].forEach(eventName => {
  dropArea.addEventListener(eventName, e => {
    e.preventDefault();
    dropArea.style.borderColor = '#cbd5e1';
    dropArea.style.background = '#f8fafc';
  }, false);
});
dropArea.addEventListener('drop', e => {
  var dt = e.dataTransfer;
  var files = dt.files;
  var fileInput = document.getElementById('file-input');
  fileInput.files = files;
  
  var event = new Event('change');
  fileInput.dispatchEvent(event);
}, false);

// Form loading state
document.querySelector('form').addEventListener('submit', function() {
  var btn = this.querySelector('.btn-primary');
  if (btn) {
    btn.innerHTML = '<i class="ti ti-loader animate-spin"></i> Menyimpan...';
    btn.disabled = true;
    btn.style.opacity = '.75';
  }
});
</script>
@endpush
@endsection
