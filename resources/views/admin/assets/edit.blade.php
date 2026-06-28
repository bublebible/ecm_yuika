@extends('layouts.admin')

@section('header')
    Edit Aset & Riwayat Kondisi
@endsection

@section('content')
    <div class="row">
        <!-- Update Info -->
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title">Informasi Dasar</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.assets.update', $asset) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="update_info" value="1">
                    <div class="card-body">
                        <div class="form-group">
                            <label>Nama Kostum <span class="text-danger">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $asset->name) }}" class="form-control @error('name') is-invalid @enderror" required>
                            <small class="form-text text-muted">Contoh: <strong>Hatsune Miku Vocaloid Maid Ver.</strong></small>
                            @error('name')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stock_qty" value="{{ old('stock_qty', $asset->stock_qty) }}" class="form-control @error('stock_qty') is-invalid @enderror" required>
                            <small class="form-text text-muted">Contoh: <strong>2</strong>. Masukkan jumlah total persediaan kostum.</small>
                            @error('stock_qty')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Harga Sewa / Hari (Rp) <span class="text-danger">*</span></label>
                            <input type="number" name="price_per_day" value="{{ old('price_per_day', $asset->price_per_day) }}" class="form-control @error('price_per_day') is-invalid @enderror" required>
                            <small class="form-text text-muted">Contoh: <strong>120000</strong>. Masukkan angka nominal saja tanpa titik atau koma.</small>
                            @error('price_per_day')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Kategori <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-control @error('category_id') is-invalid @enderror" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $asset->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Pilih kategori kelompok kostum yang sesuai.</small>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input type="checkbox" name="is_visible" class="form-check-input" id="is_visible" value="1" {{ session()->has('_old_input') ? (old('is_visible') ? 'checked' : '') : ($asset->is_visible ? 'checked' : '') }}>
                                <label class="form-check-label" for="is_visible"><strong>Tampilkan di Katalog (Dapat Disewa)</strong></label>
                            </div>
                            <small class="form-text text-muted text-xs">Centang agar kostum langsung tayang di galeri penyewaan pelanggan.</small>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Update Info</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Version History -->
        <div class="col-md-6">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Riwayat Kondisi Fisik</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted">Catatan perubahan kondisi fisik kostum dari waktu ke waktu.</p>
                    <div class="timeline timeline-inverse">
                        @foreach($asset->conditions as $condition)
                            <div>
                                <i class="fas fa-check bg-primary"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="far fa-clock"></i> {{ $condition->created_at->format('d M H:i') }}</span>
                                    <h3 class="timeline-header"><a href="#">Versi {{ $condition->version }}</a> - {{ $condition->status }}</h3>

                                    <div class="timeline-body">
                                        @if($condition->notes) 
                                            <p class="mb-2">"{{ $condition->notes }}"</p> 
                                        @endif
                                        <div class="d-flex flex-wrap">
                                            @if($condition->image)
                                                <div class="mr-3 mb-2 text-center" style="max-width: 110px;">
                                                    <a href="{{ Storage::url($condition->image) }}" target="_blank" class="d-block">
                                                        <img src="{{ Storage::url($condition->image) }}" alt="Kostum" class="img-thumbnail" style="max-height: 100px; border-radius: 4px;">
                                                    </a>
                                                    <span class="text-xs text-muted d-block font-weight-bold">Kostum</span>
                                                    <span class="text-xs text-muted text-break d-block">({{ basename($condition->image) }})</span>
                                                </div>
                                            @endif
                                            @if($condition->wig_image)
                                                <div class="mr-3 mb-2 text-center" style="max-width: 110px;">
                                                    <a href="{{ Storage::url($condition->wig_image) }}" target="_blank" class="d-block">
                                                        <img src="{{ Storage::url($condition->wig_image) }}" alt="Wig" class="img-thumbnail" style="max-height: 100px; border-radius: 4px;">
                                                    </a>
                                                    <span class="text-xs text-muted d-block font-weight-bold">Wig</span>
                                                    <span class="text-xs text-muted text-break d-block">({{ basename($condition->wig_image) }})</span>
                                                </div>
                                            @endif
                                            @if($condition->acc_image)
                                                <div class="mr-3 mb-2 text-center" style="max-width: 110px;">
                                                    <a href="{{ Storage::url($condition->acc_image) }}" target="_blank" class="d-block">
                                                        <img src="{{ Storage::url($condition->acc_image) }}" alt="Aksesoris" class="img-thumbnail" style="max-height: 100px; border-radius: 4px;">
                                                    </a>
                                                    <span class="text-xs text-muted d-block font-weight-bold">Aksesoris</span>
                                                    <span class="text-xs text-muted text-break d-block">({{ basename($condition->acc_image) }})</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if($condition->creator)
                                        <div class="timeline-footer">
                                            <span class="text-xs text-muted">Dicatat oleh: {{ $condition->creator->name }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div>
                            <i class="far fa-clock bg-gray"></i>
                        </div>
                    </div>
                </div>
                
                <div class="card-footer bg-light">
                    <h5 class="text-primary mb-3">Update Kondisi Terkini</h5>
                    <form action="{{ route('admin.assets.update', $asset) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="new_version" value="1">
                        <div class="form-group">
                            <label>Status Fisik Saat Ini <span class="text-danger">*</span></label>
                            <select name="status" class="form-control custom-select @error('status') is-invalid @enderror">
                                <option value="Good" {{ old('status', $asset->latestCondition->status ?? '') == 'Good' ? 'selected' : '' }}>Good (Baik)</option>
                                <option value="Minor Damage" {{ old('status', $asset->latestCondition->status ?? '') == 'Minor Damage' ? 'selected' : '' }}>Minor Damage (Rusak Ringan)</option>
                                <option value="Damaged" {{ old('status', $asset->latestCondition->status ?? '') == 'Damaged' ? 'selected' : '' }}>Damaged (Rusak Berat)</option>
                                <option value="Lost" {{ old('status', $asset->latestCondition->status ?? '') == 'Lost' ? 'selected' : '' }}>Lost (Hilang)</option>
                                <option value="Repaired" {{ old('status', $asset->latestCondition->status ?? '') == 'Repaired' ? 'selected' : '' }}>Repaired (Sudah Diperbaiki)</option>
                            </select>
                            <small class="form-text text-muted">Pilih status kondisi fisik kostum terbaru.</small>
                            @error('status')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label>Catatan Kerusakan/Perbaikan <span class="text-muted">(Opsional)</span></label>
                            <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" rows="2" placeholder="Contoh: Ada sedikit sobekan kecil di lengan kanan, bando patah...">{{ old('notes') }}</textarea>
                            <small class="form-text text-muted">Contoh: <strong>Kancing baju lepas satu bagian atas, wig agak kusut di bagian bawah.</strong></small>
                            @error('notes')
                                <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="image_edit">Foto Kostum Baru <span class="text-muted">(Opsional)</span></label>
                            @if($asset->latestCondition && $asset->latestCondition->image)
                                <div class="small text-muted mb-1">
                                    <strong>Foto Kostum Aktif:</strong> 
                                    <a href="{{ Storage::url($asset->latestCondition->image) }}" target="_blank" class="text-info text-decoration-none font-weight-bold">
                                        <i class="fas fa-image mr-1"></i>{{ basename($asset->latestCondition->image) }}
                                    </a>
                                </div>
                            @else
                                <div class="small text-muted mb-1"><strong>Foto Kostum Aktif:</strong> Belum ada foto kostum</div>
                            @endif
                            <div class="input-group mb-1">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input @error('image') is-invalid @enderror" id="image_edit" onchange="previewImageEdit(event, 'imagePreviewEdit', 'imagePreviewContainerEdit')">
                                    <label class="custom-file-label" for="image_edit">Pilih file baru</label>
                                </div>
                            </div>
                            <small class="form-text text-muted d-block mb-2">Format gambar (.jpg, .jpeg, .png). Maksimal ukuran file <strong>2MB</strong>.</small>
                            @error('image')
                                <span class="text-danger small d-block mb-2"><strong>{{ $message }}</strong></span>
                            @enderror
                            <div id="imagePreviewContainerEdit" style="display: none;">
                                <div class="mt-2 text-muted small mb-1">Pratinjau Foto Kostum Baru:</div>
                                <div class="position-relative d-inline-block">
                                    <img id="imagePreviewEdit" src="#" alt="Pratinjau" class="img-thumbnail" style="max-height: 200px; max-width: 100%; border-radius: 8px;">
                                    <button type="button" class="btn btn-danger btn-xs position-absolute shadow-sm" onclick="removeImagePreviewEdit('image_edit', 'imagePreviewContainerEdit')" style="top: -10px; right: -10px; border-radius: 50%; width: 24px; height: 24px; padding: 0; line-height: 24px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="wig_image_edit">Foto Wig Baru <span class="text-muted">(Opsional)</span></label>
                            @if($asset->latestCondition && $asset->latestCondition->wig_image)
                                <div class="small text-muted mb-1">
                                    <strong>Foto Wig Aktif:</strong> 
                                    <a href="{{ Storage::url($asset->latestCondition->wig_image) }}" target="_blank" class="text-info text-decoration-none font-weight-bold">
                                        <i class="fas fa-image mr-1"></i>{{ basename($asset->latestCondition->wig_image) }}
                                    </a>
                                </div>
                            @else
                                <div class="small text-muted mb-1"><strong>Foto Wig Aktif:</strong> Belum ada foto wig</div>
                            @endif
                            <div class="input-group mb-1">
                                <div class="custom-file">
                                    <input type="file" name="wig_image" class="custom-file-input @error('wig_image') is-invalid @enderror" id="wig_image_edit" onchange="previewImageEdit(event, 'wigImagePreviewEdit', 'wigImagePreviewContainerEdit')">
                                    <label class="custom-file-label" for="wig_image_edit">Pilih file baru</label>
                                </div>
                            </div>
                            <small class="form-text text-muted d-block mb-2">Format gambar (.jpg, .jpeg, .png). Maksimal ukuran file <strong>2MB</strong>.</small>
                            @error('wig_image')
                                <span class="text-danger small d-block mb-2"><strong>{{ $message }}</strong></span>
                            @enderror
                            <div id="wigImagePreviewContainerEdit" style="display: none;">
                                <div class="mt-2 text-muted small mb-1">Pratinjau Foto Wig Baru:</div>
                                <div class="position-relative d-inline-block">
                                    <img id="wigImagePreviewEdit" src="#" alt="Pratinjau Wig" class="img-thumbnail" style="max-height: 200px; max-width: 100%; border-radius: 8px;">
                                    <button type="button" class="btn btn-danger btn-xs position-absolute shadow-sm" onclick="removeImagePreviewEdit('wig_image_edit', 'wigImagePreviewContainerEdit')" style="top: -10px; right: -10px; border-radius: 50%; width: 24px; height: 24px; padding: 0; line-height: 24px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="acc_image_edit">Foto Aksesoris Baru <span class="text-muted">(Opsional)</span></label>
                            @if($asset->latestCondition && $asset->latestCondition->acc_image)
                                <div class="small text-muted mb-1">
                                    <strong>Foto Aksesoris Aktif:</strong> 
                                    <a href="{{ Storage::url($asset->latestCondition->acc_image) }}" target="_blank" class="text-info text-decoration-none font-weight-bold">
                                        <i class="fas fa-image mr-1"></i>{{ basename($asset->latestCondition->acc_image) }}
                                    </a>
                                </div>
                            @else
                                <div class="small text-muted mb-1"><strong>Foto Aksesoris Aktif:</strong> Belum ada foto aksesoris</div>
                            @endif
                            <div class="input-group mb-1">
                                <div class="custom-file">
                                    <input type="file" name="acc_image" class="custom-file-input @error('acc_image') is-invalid @enderror" id="acc_image_edit" onchange="previewImageEdit(event, 'accImagePreviewEdit', 'accImagePreviewContainerEdit')">
                                    <label class="custom-file-label" for="acc_image_edit">Pilih file baru</label>
                                </div>
                            </div>
                            <small class="form-text text-muted d-block mb-2">Format gambar (.jpg, .jpeg, .png). Maksimal ukuran file <strong>2MB</strong>.</small>
                            @error('acc_image')
                                <span class="text-danger small d-block mb-2"><strong>{{ $message }}</strong></span>
                            @enderror
                            <div id="accImagePreviewContainerEdit" style="display: none;">
                                <div class="mt-2 text-muted small mb-1">Pratinjau Foto Aksesoris Baru:</div>
                                <div class="position-relative d-inline-block">
                                    <img id="accImagePreviewEdit" src="#" alt="Pratinjau Aksesoris" class="img-thumbnail" style="max-height: 200px; max-width: 100%; border-radius: 8px;">
                                    <button type="button" class="btn btn-danger btn-xs position-absolute shadow-sm" onclick="removeImagePreviewEdit('acc_image_edit', 'accImagePreviewContainerEdit')" style="top: -10px; right: -10px; border-radius: 50%; width: 24px; height: 24px; padding: 0; line-height: 24px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success float-right">Simpan Update Kondisi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImageEdit(event, previewId, containerId) {
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

        function removeImagePreviewEdit(inputId, containerId) {
            const fileInput = document.getElementById(inputId);
            if (fileInput) {
                fileInput.value = '';
                $(fileInput).siblings('.custom-file-label').html('Pilih file');
            }
            document.getElementById(containerId).style.display = 'none';
        }
    </script>
@endsection
