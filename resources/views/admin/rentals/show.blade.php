@extends('layouts.admin')

@section('header')
    Detail Penyewaan #{{ $rental->id }}
@endsection

@section('content')
@section('content')
    <div class="row">
        <!-- Info -->
        <div class="col-md-6">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Informasi Penyewa</h3>
                </div>
                <div class="card-body">
                    <strong><i class="fas fa-user mr-1"></i> Nama</strong>
                    <p class="text-muted">{{ $rental->user->name }}</p>
                    <hr>
                    <strong><i class="fas fa-envelope mr-1"></i> Email</strong>
                    <p class="text-muted">{{ $rental->user->email }}</p>
                    <hr>
                    <strong><i class="fas fa-phone mr-1"></i> Telepon</strong>
                    <p class="text-muted">{{ $rental->user->phone ?? '-' }}</p>
                    <hr>
                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>
                    <p class="text-muted">{{ $rental->user->address ?? '-' }}</p>
                    <hr>
                    <strong><i class="fas fa-id-card mr-1"></i> Status KTP Akun</strong>
                    <p class="text-muted mb-1">
                        @php
                            $ktpStatusBadge = match($rental->user->ktp_status ?? 'unverified') {
                                'verified'  => 'badge-success',
                                'pending'   => 'badge-warning',
                                'rejected'  => 'badge-danger',
                                default     => 'badge-secondary',
                            };
                        @endphp
                        <span class="badge {{ $ktpStatusBadge }}">{{ ucfirst($rental->user->ktp_status ?? 'unverified') }}</span>
                    </p>
                    @if($rental->user->ktp_image)
                        <div class="mt-2">
                            <a href="{{ Storage::url($rental->user->ktp_image) }}" target="_blank" class="btn btn-xs btn-outline-primary">
                                <i class="fas fa-eye"></i> Lihat Foto KTP Profil
                            </a>
                        </div>
                    @endif

                    <h4 class="mt-4 mb-2">Detail Sewa</h4>
                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Periode</b> <span class="float-right">{{ $rental->start_date->format('d M Y') }} - {{ $rental->end_date->format('d M Y') }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Total</b> <span class="float-right">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Status Sewa</b> <span class="float-right badge badge-info">{{ ucfirst($rental->status) }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Status Pembayaran</b>
                            @php
                                $paymentBadgesShow = [
                                    'unpaid' => 'badge-danger',
                                    'pending' => 'badge-warning',
                                    'paid' => 'badge-success',
                                    'failed' => 'badge-danger',
                                    'cancelled' => 'badge-secondary'
                                ];
                                $payBadgeClassShow = $paymentBadgesShow[$rental->payment_status] ?? 'badge-secondary';
                                
                                $paymentStatusTextsShow = [
                                    'unpaid' => 'Belum Bayar',
                                    'pending' => 'Pending / Menunggu',
                                    'paid' => 'Sudah Bayar',
                                    'failed' => 'Gagal',
                                    'cancelled' => 'Batal'
                                ];
                                $paymentStatusTextShow = $paymentStatusTextsShow[$rental->payment_status] ?? ucfirst($rental->payment_status);
                            @endphp
                            <span class="float-right badge {{ $payBadgeClassShow }}">
                                @if($rental->payment_status === 'paid')
                                    <i class="fas fa-check-circle mr-1"></i>
                                @endif
                                {{ $paymentStatusTextShow }}
                            </span>
                        </li>
                        @if($rental->paid_at)
                            <li class="list-group-item">
                                <b>Waktu Pembayaran</b> <span class="float-right text-muted">{{ $rental->paid_at->format('d/m/Y H:i') }}</span>
                            </li>
                        @endif
                    </ul>

                    <!-- ACTIONS -->
                    <div class="mt-4">
                        @if($rental->status == 'pending')
                            <form action="{{ route('admin.rentals.update', $rental) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="approve_rental" value="1">
                                <button onclick="return confirm('Setujui penyewaan? Pastikan identitas sudah valid.')" class="btn btn-success btn-block">
                                    <i class="fas fa-check"></i> Setujui & Generate Kontrak
                                </button>
                            </form>
                        @elseif($rental->status == 'approved')
                            <a href="{{ route('admin.rentals.contract', $rental) }}" class="btn btn-secondary btn-block mb-2">
                                <i class="fas fa-file-pdf"></i> Preview Kontrak
                            </a>
                            <form action="{{ route('admin.rentals.update', $rental) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="start_rental" value="1">
                                <button onclick="return confirm('Mulai sewa? Artinya barang sudah diambil user.')" class="btn btn-primary btn-block">
                                    <i class="fas fa-play"></i> Tandai Barang Diambil (Start)
                                </button>
                            </form>
                        @elseif($rental->status == 'active')
                            <div class="alert alert-info">
                                <i class="icon fas fa-info"></i> Sedang disewa. Menunggu pengembalian.
                            </div>
                        @elseif($rental->status == 'returned')
                            <form action="{{ route('admin.rentals.update', $rental) }}" method="POST">
                                @csrf @method('PUT')
                                <input type="hidden" name="complete_rental" value="1">
                                <button onclick="return confirm('Selesaikan dan Arsipkan? Pastikan kondisi aset sudah dicek.')" class="btn btn-dark btn-block">
                                    <i class="fas fa-archive"></i> Selesai & Arsipkan
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents -->
        <div class="col-md-6">
            <div class="card card-secondary">
                <div class="card-header">
                    <h3 class="card-title">Dokumen Validasi</h3>
                </div>
                <div class="card-body">
                    @forelse($rental->documents as $doc)
                        <div class="callout callout-{{ $doc->status == 'valid' ? 'success' : ($doc->status == 'rejected' ? 'danger' : 'warning') }}">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5>{{ ucfirst(str_replace('_', ' ', $doc->type)) }}</h5>
                                    <p class="text-xs mb-1">Uploaded: {{ $doc->created_at->format('d M H:i') }}</p>
                                    <span class="badge badge-{{ $doc->status == 'valid' ? 'success' : ($doc->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($doc->status) }}
                                    </span>
                                </div>
                                <div>
                                    <a href="{{ Storage::url($doc->file_path) }}" target="_blank" class="btn btn-xs btn-default">
                                        <i class="fas fa-external-link-alt"></i> Lihat File
                                    </a>
                                </div>
                            </div>

                            @if($doc->status == 'pending')
                                <form action="{{ route('admin.rentals.update', $rental) }}" method="POST" class="mt-3">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="validate_doc" value="1">
                                    <input type="hidden" name="doc_id" value="{{ $doc->id }}">
                                    
                                    <div class="form-group">
                                        <textarea name="admin_note" class="form-control form-control-sm" placeholder="Catatan admin..." rows="2"></textarea>
                                    </div>
                                    <div class="btn-group w-100">
                                        <button type="submit" name="doc_status" value="valid" class="btn btn-success btn-sm">
                                            <i class="fas fa-check"></i> Valid
                                        </button>
                                        <button type="submit" name="doc_status" value="rejected" class="btn btn-danger btn-sm">
                                            <i class="fas fa-times"></i> Reject
                                        </button>
                                    </div>
                                </form>
                            @else
                                @if($doc->admin_note)
                                    <div class="mt-2 text-muted font-italic text-sm border-top pt-2">
                                        Note: {{ $doc->admin_note }}
                                    </div>
                                @endif
                            @endif
                        </div>
                    @empty
                        <p class="text-muted text-center py-4">Belum ada dokumen diupload.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
