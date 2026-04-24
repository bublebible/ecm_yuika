@extends('layouts.admin')

@section('header')
    Edit Konten
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Konten</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{ route('admin.content.update', $post) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" name="title" value="{{ $post->title }}" class="form-control" id="title" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Konten (Isi)</label>
                            <textarea name="content" class="form-control" id="content" rows="10" required>{{ $post->content }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Gambar Utama (Opsional)</label>
                            @if($post->image)
                                <div class="mb-2">
                                    <img src="{{ Storage::url($post->image) }}" alt="Current Image" class="img-thumbnail" style="max-height: 150px;">
                                </div>
                            @endif
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="image" class="custom-file-input" id="image">
                                    <label class="custom-file-label" for="image">Pilih file</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" name="is_published" class="form-check-input" id="is_published" value="1" {{ $post->is_published ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_published">Publikasikan?</label>
                        </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-warning">Update Konten</button>
                        <a href="{{ route('admin.content.index') }}" class="btn btn-default float-right">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
