@extends('layouts.admin')

@section('header')
    Buat Konten Baru
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Form Buat Konten</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.content.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Masukkan judul artikel" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Konten (Isi)</label>
                            <textarea name="content" class="form-control" id="content" rows="10" placeholder="Tulis konten di sini..." required></textarea>
                            <small class="text-muted">Anda bisa menggunakan tag HTML sederhana.</small>
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar Utama (Opsional)</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">Pilih file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_published" class="form-check-input" id="is_published" value="1" checked>
                            <label class="form-check-label" for="is_published">Publikasikan Langsung?</label>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan Konten</button>
                        <a href="{{ route('admin.content.index') }}" class="btn btn-default float-right">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
