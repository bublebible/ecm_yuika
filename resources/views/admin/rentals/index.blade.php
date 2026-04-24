@extends('layouts.admin')

@section('header')
    Daftar Penyewaan (Admin)
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Data Transaksi Penyewaan</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 150px;">
                            <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Penyewa</th>
                                <th>Aset Disewa</th>
                                <th>Tanggal Sewa</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rentals as $rental)
                                <tr>
                                    <td>{{ $rental->id }}</td>
                                    <td>
                                        {{ $rental->user->name }}<br>
                                        <small class="text-muted">{{ $rental->user->email }}</small>
                                    </td>
                                    <td>
                                        @foreach($rental->items as $item)
                                            <span class="d-block">- {{ $item->asset->name }} (x{{ $item->qty }})</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $rental->start_date->format('d/m/Y') }}<br>
                                        <small class="text-muted">s/d {{ $rental->end_date->format('d/m/Y') }}</small>
                                    </td>
                                    <td>
                                        @php
                                            $badges = [
                                                'pending' => 'warning',
                                                'approved' => 'primary',
                                                'active' => 'success',
                                                'returned' => 'info',
                                                'completed' => 'secondary'
                                            ];
                                            $badgeClass = $badges[$rental->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge badge-{{ $badgeClass }}">{{ ucfirst($rental->status) }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.rentals.show', $rental) }}" class="btn btn-sm btn-primary">
                                            <i class="fas fa-eye"></i> Detail & Validasi
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center">Tidak ada data penyewaan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
                <div class="card-footer clearfix">
                    {{ $rentals->links('pagination::bootstrap-4') }}
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
