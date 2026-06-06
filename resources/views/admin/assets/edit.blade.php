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
                            <label>Nama Aset</label>
                            <input type="text" name="name" value="{{ $asset->name }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Stok</label>
                            <input type="number" name="stock_qty" value="{{ $asset->stock_qty }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Sewa</label>
                            <input type="number" name="price_per_day" value="{{ $asset->price_per_day }}" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ $asset->category_id == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->name }}
                                    </option>
                                @endforeach
                            </select>
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
                                            <p class="mb-1">"{{ $condition->notes }}"</p> 
                                        @endif
                                        @if($condition->image)
                                            <a href="{{ Storage::url($condition->image) }}" target="_blank">
                                                <img src="{{ Storage::url($condition->image) }}" alt="..." class="margin" style="max-height: 100px; border-radius: 4px;">
                                            </a>
                                        @endif
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
                            <label>Status Fisik Saat Ini</label>
                            <select name="status" class="form-control custom-select">
                                <option value="Good">Good (Baik)</option>
                                <option value="Minor Damage">Minor Damage (Rusak Ringan)</option>
                                <option value="Damaged">Damaged (Rusak Berat)</option>
                                <option value="Lost">Lost (Hilang)</option>
                                <option value="Repaired">Repaired (Sudah Diperbaiki)</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Catatan Kerusakan/Perbaikan</label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Contoh: Ada sobekan kecil di bagian lengan..."></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputFile">Foto Bukti (Opsional)</label>
                            <div class="input-group mb-2">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="exampleInputFile" onchange="previewImageEdit(event)">
                                    <label class="custom-file-label" for="exampleInputFile">Pilih file</label>
                                </div>
                            </div>
                            <div id="imagePreviewContainerEdit" style="display: none;">
                                <div class="mt-2 text-muted small mb-1">Pratinjau Foto Baru:</div>
                                <div class="position-relative d-inline-block">
                                    <img id="imagePreviewEdit" src="#" alt="Pratinjau" class="img-thumbnail" style="max-height: 200px; max-width: 100%; border-radius: 8px;">
                                    <button type="button" class="btn btn-danger btn-xs position-absolute shadow-sm" onclick="removeImagePreviewEdit()" style="top: -10px; right: -10px; border-radius: 50%; width: 24px; height: 24px; padding: 0; line-height: 24px; display: flex; align-items: center; justify-content: center;">
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
        function previewImageEdit(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('imagePreviewEdit');
                output.src = reader.result;
                document.getElementById('imagePreviewContainerEdit').style.display = 'block';
            };
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
                // Update label name with selected file name
                const fileName = event.target.files[0].name;
                $(event.target).siblings('.custom-file-label').html(fileName);
            }
        }

        function removeImagePreviewEdit() {
            const fileInput = document.getElementById('exampleInputFile');
            if (fileInput) {
                fileInput.value = '';
                $(fileInput).siblings('.custom-file-label').html('Pilih file');
            }
            document.getElementById('imagePreviewContainerEdit').style.display = 'none';
        }
    </script>
@endsection
