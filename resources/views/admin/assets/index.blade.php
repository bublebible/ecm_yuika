@extends('layouts.admin')

@section('header')
    Manajemen Aset (Admin)
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Inventory Kostum</h3>
            <div class="card-tools">
                <a href="{{ route('admin.assets.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Kostum
                </a>
            </div>
        </div>
        <div class="card-body">
            <!-- Search Form -->
            <form action="{{ route('admin.assets.index') }}" method="GET" class="mb-3">
                <div class="input-group input-group-sm" style="width: 250px;">
                    <input type="text" name="search" class="form-control float-right" placeholder="Cari kostum..." value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button type="submit" class="btn btn-default">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="icon fas fa-check"></i> {{ session('success') }}
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Info Aset</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                            <th>Kondisi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assets as $asset)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-indigo rounded-circle d-flex align-items-center justify-content-center mr-3" style="width: 40px; height: 40px; font-weight: bold; color: white;">
                                            {{ substr($asset->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="font-weight-bold">{{ $asset->name }}</div>
                                            <div class="text-muted small">Code: {{ $asset->code }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $asset->category }}</td>
                                <td>
                                    <span class="badge {{ $asset->stock_qty > 0 ? 'badge-primary' : 'badge-secondary' }}">
                                        {{ $asset->stock_qty }} Unit
                                    </span>
                                </td>
                                <td>
                                    @if($asset->latestCondition)
                                        @php
                                            $statusColors = [
                                                'Good' => 'success',
                                                'Baik' => 'success',
                                                'Damaged' => 'danger',
                                                'Rusak' => 'danger',
                                                'Repaired' => 'warning',
                                            ];
                                            $badgeClass = $statusColors[$asset->latestCondition->status] ?? 'secondary';
                                        @endphp
                                        <span class="badge badge-{{ $badgeClass }}">
                                            {{ $asset->latestCondition->status }}
                                        </span>
                                        <small class="text-muted d-block">Riwayat Ke-{{ $asset->latestCondition->version }}</small>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.assets.edit', $asset) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i> Edit & Riwayat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">
                                    Belum ada aset yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer clearfix">
            {{ $assets->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection
