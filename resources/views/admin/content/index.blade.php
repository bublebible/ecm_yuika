@extends('layouts.admin')

@section('header')
    Manajemen Konten (Blog & Tips)
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Daftar Konten / Artikel</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.content.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Buat Konten Baru
                        </a>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Tanggal Dibuat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($posts as $post)
                                <tr>
                                    <td>
                                        <strong>{{ $post->title }}</strong><br>
                                        <small class="text-muted">{{ Str::limit(strip_tags($post->content), 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $post->is_published ? 'success' : 'secondary' }}">
                                            {{ $post->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </td>
                                    <td>{{ $post->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <a href="{{ route('admin.content.edit', $post) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="{{ route('admin.content.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus konten ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada konten.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $posts->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>
@endsection
