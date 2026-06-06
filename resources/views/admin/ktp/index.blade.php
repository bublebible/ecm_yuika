@extends('layouts.admin')

@section('header')
    Verifikasi KTP Pengguna
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            {{-- Alert messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            {{-- Filter Tabs --}}
            <div class="card card-pink card-outline card-outline-tabs">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="ktp-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'pending' ? 'active' : '' }}" href="{{ route('admin.ktp.index', ['status' => 'pending']) }}">
                                <i class="fas fa-clock mr-1 text-warning"></i> Menunggu Verifikasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'verified' ? 'active' : '' }}" href="{{ route('admin.ktp.index', ['status' => 'verified']) }}">
                                <i class="fas fa-check-circle mr-1 text-success"></i> Diverifikasi
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'rejected' ? 'active' : '' }}" href="{{ route('admin.ktp.index', ['status' => 'rejected']) }}">
                                <i class="fas fa-times-circle mr-1 text-danger"></i> Ditolak
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ $status === 'all' ? 'active' : '' }}" href="{{ route('admin.ktp.index', ['status' => 'all']) }}">
                                <i class="fas fa-list mr-1"></i> Semua Pengguna
                            </a>
                        </li>
                    </ul>
                </div>
                
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID User</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>No. HP</th>
                                <th>Foto KTP / KTM</th>
                                <th>Status</th>
                                <th style="width: 220px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td><strong>{{ $user->name }}</strong></td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->phone ?? '-' }}</td>
                                    <td>
                                        @if($user->ktp_image)
                                            <button type="button" class="btn btn-xs btn-info" 
                                                    onclick="previewKtp('{{ Storage::url($user->ktp_image) }}', '{{ $user->name }}')">
                                                <i class="fas fa-image mr-1"></i> Lihat KTP
                                            </button>
                                        @else
                                            <span class="text-muted italic">Belum Unggah</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->ktp_status === 'verified')
                                            <span class="badge badge-success"><i class="fas fa-check mr-1"></i> Verified</span>
                                        @elseif($user->ktp_status === 'pending')
                                            <span class="badge badge-warning text-white" style="background-color: #f39c12;"><i class="fas fa-clock mr-1"></i> Pending</span>
                                        @elseif($user->ktp_status === 'rejected')
                                            <span class="badge badge-danger" title="{{ $user->ktp_rejection_reason }}">
                                                <i class="fas fa-times mr-1"></i> Rejected
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">Unverified</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->ktp_status === 'pending')
                                            <div class="d-flex align-items-center">
                                                <form action="{{ route('admin.ktp.verify', $user) }}" method="POST" class="mr-1">
                                                    @csrf
                                                    <button type="submit" class="btn btn-xs btn-success" onclick="return confirm('Apakah Anda yakin ingin menyetujui verifikasi KTP ini?')">
                                                        <i class="fas fa-check"></i> Setuju
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-xs btn-danger" onclick="openRejectModal('{{ $user->id }}', '{{ $user->name }}')">
                                                    <i class="fas fa-times"></i> Tolak
                                                </button>
                                            </div>
                                        @elseif($user->ktp_status === 'rejected')
                                            <form action="{{ route('admin.ktp.verify', $user) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-xs btn-outline-success">
                                                    <i class="fas fa-check"></i> Setujui Ulang
                                                </button>
                                            </form>
                                        @elseif($user->ktp_status === 'verified')
                                            <button type="button" class="btn btn-xs btn-outline-danger" onclick="openRejectModal('{{ $user->id }}', '{{ $user->name }}')">
                                                <i class="fas fa-times"></i> Batalkan Verifikasi
                                            </button>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="fas fa-folder-open fa-2x mb-2 d-block"></i>
                                        Tidak ada data pengguna untuk status ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="card-footer clearfix">
                    {{ $users->appends(['status' => $status])->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </div>
    </div>

    {{-- KTP PREVIEW MODAL --}}
    <div class="modal fade" id="ktpPreviewModal" tabindex="-1" role="dialog" aria-labelledby="ktpPreviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ktpPreviewModalLabel">Foto KTP - <span id="previewName"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center bg-dark">
                    <img id="previewImage" src="" class="img-fluid rounded" style="max-height: 500px;" alt="KTP Preview">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    {{-- REJECTION REASON MODAL --}}
    <div class="modal fade" id="rejectKtpModal" tabindex="-1" role="dialog" aria-labelledby="rejectKtpModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="rejectKtpModalLabel">Tolak Verifikasi KTP</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Anda akan menolak verifikasi KTP untuk user: <strong id="rejectUserName"></strong></p>
                        <div class="form-group">
                            <label for="rejection_reason">Alasan Penolakan <span class="text-danger">*</span></label>
                            <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="4" placeholder="Tulis alasan penolakan, contoh: Foto KTP blur / tidak terbaca dengan jelas." required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak Sekarang</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewKtp(url, name) {
            $('#previewImage').attr('src', url);
            $('#previewName').text(name);
            $('#ktpPreviewModal').modal('show');
        }

        function openRejectModal(id, name) {
            const actionUrl = "{{ url('/admin/ktp') }}/" + id + "/reject";
            $('#rejectForm').attr('action', actionUrl);
            $('#rejectUserName').text(name);
            $('#rejection_reason').val('');
            $('#rejectKtpModal').modal('show');
        }
    </script>
@endsection
