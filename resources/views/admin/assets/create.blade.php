@extends('layouts.admin')

@section('header')
    Tambah Kostum Baru
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Tambah Kostum</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.assets.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="code">Kode Kostum <span class="text-danger">*</span></label>
                                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" id="code" placeholder="Contoh: KSM-001 atau MIKU-01" value="{{ old('code') }}" required>
                                    <small class="form-text text-muted">Contoh: <strong>KSM-001</strong> atau <strong>MIKU-01</strong>. Kode ini harus unik (tidak boleh sama dengan kostum lain).</small>
                                    @error('code')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name">Nama Kostum <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Contoh: Hatsune Miku Vocaloid Maid Ver." value="{{ old('name') }}" required>
                                    <small class="form-text text-muted">Contoh: <strong>Hatsune Miku Vocaloid Maid Ver.</strong> atau <strong>Naruto Shippuden Sage Mode</strong>.</small>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="category_id">Kategori <span class="text-danger">*</span></label>
                                    <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" id="category_id" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <small class="form-text text-muted">Pilih kategori kelompok kostum yang sesuai.</small>
                                    @error('category_id')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="price_per_day">Harga Sewa / Hari (Rp) <span class="text-danger">*</span></label>
                                    <input type="number" name="price_per_day" class="form-control @error('price_per_day') is-invalid @enderror" id="price_per_day" placeholder="Contoh: 120000" value="{{ old('price_per_day') }}" required>
                                    <small class="form-text text-muted">Contoh: <strong>120000</strong>. Masukkan angka nominal saja tanpa tanda titik atau koma.</small>
                                    @error('price_per_day')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="is_visible" class="form-check-input" id="is_visible" value="1" {{ old('is_visible') === null && session()->has('_old_input') ? '' : 'checked' }}>
                                        <label class="form-check-label" for="is_visible"><strong>Tampilkan di Katalog (Dapat Disewa)</strong></label>
                                    </div>
                                    <small class="form-text text-muted text-xs">Centang agar kostum langsung tayang di galeri penyewaan pelanggan.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stock_qty">Stok Awal <span class="text-danger">*</span></label>
                                    <input type="number" name="stock_qty" class="form-control @error('stock_qty') is-invalid @enderror" id="stock_qty" placeholder="Contoh: 1" value="{{ old('stock_qty') }}" required>
                                    <small class="form-text text-muted">Contoh: <strong>1</strong> atau <strong>3</strong>. Jumlah persediaan kostum yang siap disewakan.</small>
                                    @error('stock_qty')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="condition_status">Kondisi Awal <span class="text-danger">*</span></label>
                                    <select name="condition_status" class="form-control @error('condition_status') is-invalid @enderror" id="condition_status">
                                        <option value="Good" {{ old('condition_status') == 'Good' ? 'selected' : '' }}>Good (Baik)</option>
                                        <option value="Minor Damage" {{ old('condition_status') == 'Minor Damage' ? 'selected' : '' }}>Minor Damage (Rusak Ringan)</option>
                                        <option value="Damaged" {{ old('condition_status') == 'Damaged' ? 'selected' : '' }}>Damaged (Rusak Berat)</option>
                                    </select>
                                    <small class="form-text text-muted">Tentukan kondisi fisik awal dari kostum saat pertama kali didaftarkan.</small>
                                    @error('condition_status')
                                        <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="description">Deskripsi <span class="text-muted">(Opsional)</span></label>
                                    <textarea name="description" class="form-control" id="description" rows="2" placeholder="Contoh: Set kostum lengkap, bahan kain premium dingin...">{{ old('description') }}</textarea>
                                    <small class="form-text text-muted">Contoh: <strong>Set baju lengkap, rompi, wig biru, bando aksesoris, sarung tangan putih.</strong></small>
                                </div>
                                <div class="form-group">
                                    <label for="condition_notes">Catatan Kondisi <span class="text-muted">(Opsional)</span></label>
                                    <textarea name="condition_notes" class="form-control" id="condition_notes" rows="2" placeholder="Contoh: Kondisi kain 100% mulus baru, wig rapi dalam hairnet...">{{ old('condition_notes') }}</textarea>
                                    <small class="form-text text-muted">Contoh: <strong>Kain mulus 100% dari penjahit, wig rapi dan bersih dalam kemasan asli.</strong></small>
                                </div>
                                <div class="form-group">
                                    <label for="image">Foto Kostum <span class="text-muted">(Opsional)</span></label>
                                    <div class="input-group mb-1">
                                        <div class="custom-file">
                                            <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image" onchange="previewImage(event, 'imagePreview', 'imagePreviewContainer')">
                                            <label class="custom-file-label" for="image">Pilih file</label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted d-block mb-2">Format gambar (.jpg, .jpeg, .png). Maksimal ukuran file <strong>2MB</strong>.</small>
                                    @error('image')
                                        <span class="text-danger small d-block mb-2"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    <div id="imagePreviewContainer" style="display: none;">
                                        <div class="mt-2 text-muted small mb-1">Pratinjau Foto Kostum:</div>
                                        <div class="position-relative d-inline-block">
                                            <img id="imagePreview" src="#" alt="Pratinjau" class="img-thumbnail" style="max-height: 200px; max-width: 100%; border-radius: 8px;">
                                            <button type="button" class="btn btn-danger btn-xs position-absolute shadow-sm" onclick="removeImagePreview('image', 'imagePreviewContainer')" style="top: -10px; right: -10px; border-radius: 50%; width: 24px; height: 24px; padding: 0; line-height: 24px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="wig_image">Foto Wig <span class="text-muted">(Opsional)</span></label>
                                    <div class="input-group mb-1">
                                        <div class="custom-file">
                                            <input type="file" name="wig_image" class="custom-file-input @error('wig_image') is-invalid @enderror" id="wig_image" onchange="previewImage(event, 'wigImagePreview', 'wigImagePreviewContainer')">
                                            <label class="custom-file-label" for="wig_image">Pilih file</label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted d-block mb-2">Format gambar (.jpg, .jpeg, .png). Maksimal ukuran file <strong>2MB</strong>.</small>
                                    @error('wig_image')
                                        <span class="text-danger small d-block mb-2"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    <div id="wigImagePreviewContainer" style="display: none;">
                                        <div class="mt-2 text-muted small mb-1">Pratinjau Foto Wig:</div>
                                        <div class="position-relative d-inline-block">
                                            <img id="wigImagePreview" src="#" alt="Pratinjau Wig" class="img-thumbnail" style="max-height: 200px; max-width: 100%; border-radius: 8px;">
                                            <button type="button" class="btn btn-danger btn-xs position-absolute shadow-sm" onclick="removeImagePreview('wig_image', 'wigImagePreviewContainer')" style="top: -10px; right: -10px; border-radius: 50%; width: 24px; height: 24px; padding: 0; line-height: 24px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="acc_image">Foto Aksesoris (ACC) <span class="text-muted">(Opsional)</span></label>
                                    <div class="input-group mb-1">
                                        <div class="custom-file">
                                            <input type="file" name="acc_image" class="custom-file-input @error('acc_image') is-invalid @enderror" id="acc_image" onchange="previewImage(event, 'accImagePreview', 'accImagePreviewContainer')">
                                            <label class="custom-file-label" for="acc_image">Pilih file</label>
                                        </div>
                                    </div>
                                    <small class="form-text text-muted d-block mb-2">Format gambar (.jpg, .jpeg, .png). Maksimal ukuran file <strong>2MB</strong>.</small>
                                    @error('acc_image')
                                        <span class="text-danger small d-block mb-2"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    <div id="accImagePreviewContainer" style="display: none;">
                                        <div class="mt-2 text-muted small mb-1">Pratinjau Foto Aksesoris:</div>
                                        <div class="position-relative d-inline-block">
                                            <img id="accImagePreview" src="#" alt="Pratinjau Aksesoris" class="img-thumbnail" style="max-height: 200px; max-width: 100%; border-radius: 8px;">
                                            <button type="button" class="btn btn-danger btn-xs position-absolute shadow-sm" onclick="removeImagePreview('acc_image', 'accImagePreviewContainer')" style="top: -10px; right: -10px; border-radius: 50%; width: 24px; height: 24px; padding: 0; line-height: 24px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
 
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan Kostum</button>
                        <a href="{{ route('admin.assets.index') }}" class="btn btn-default float-right">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
 
    <script>
        function previewImage(event, previewId, containerId) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById(previewId);
                output.src = reader.result;
                document.getElementById(containerId).style.display = 'block';
            };
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
                // Update label name with selected file name
                const fileName = event.target.files[0].name;
                $(event.target).siblings('.custom-file-label').html(fileName);
            }
        }
 
        function removeImagePreview(inputId, containerId) {
            const fileInput = document.getElementById(inputId);
            if (fileInput) {
                fileInput.value = '';
                $(fileInput).siblings('.custom-file-label').html('Pilih file');
            }
            document.getElementById(containerId).style.display = 'none';
        }
    </script>
@endsection
