@extends('layouts.admin')

@section('header')
    <!-- Empty header as we customize it inside content -->
@endsection

@section('content')
    <style>
        /* Custom Dashboard Theme */
        .content-wrapper {
            background-color: #fdf2f8 !important; /* Pink-50 */
        }
        .card-modern {
            border: none;
            border-radius: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s;
            overflow: hidden;
        }
        .card-modern:hover {
            transform: translateY(-2px);
        }
        .icon-box {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }
        .bg-gradient-pink-modern {
            background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);
            color: white;
        }
        .text-pink-modern {
            color: #db2777;
        }
        .badge-soft-pink {
            background-color: #fce7f3;
            color: #be185d;
        }
        .badge-soft-success {
            background-color: #dcfce7;
            color: #15803d;
        }
        /* Override AdminLTE overrides */
        .content-header {
            padding: 0;
        }
    </style>

    <div class="pt-3">
        <!-- Welcome Section -->
        <div class="d-flex align-items-center mb-4 pl-2">
            <div class="bg-white p-1 rounded-circle shadow-sm mr-3">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=db2777&color=fff" class="rounded-circle" width="48" height="48">
            </div>
            <div>
                <h5 class="mb-0 text-muted" style="font-size: 0.9rem;">Welcome Back,</h5>
                <h3 class="font-weight-bold text-dark mb-0">{{ Auth::user()->name }}</h3>
            </div>
            <div class="ml-auto">
                <button class="btn btn-white shadow-sm rounded-circle p-2 disabled">
                    <i class="fas fa-bell text-pink-modern"></i>
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="row">
            <!-- Card 1: Total Assets (Income Proxy) -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-modern bg-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="icon-box bg-light text-success">
                                <i class="fas fa-wallet"></i>
                            </div>
                            <span class="badge badge-soft-success rounded-pill px-3 py-1">+12%</span>
                        </div>
                        <div class="mt-4">
                            <h6 class="text-muted mb-1">Total Asset Value (Est)</h6>
                            <h2 class="font-weight-bold text-dark">${{ number_format($totalAssets * 150000 / 15000, 2) }}</h2> 
                            <!-- Fake calculation for demo visuals, assuming ~Rp150k avg value -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Active Rentals (Highlight) -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-modern bg-gradient-pink-modern h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="icon-box" style="background: rgba(255,255,255,0.2);">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <span class="badge bg-white text-pink-modern rounded-pill px-3 py-1">Active</span>
                        </div>
                        <div class="mt-4">
                            <h6 class="text-white-50 mb-1">Active Rentals</h6>
                            <h2 class="font-weight-bold text-white">{{ $activeRentals }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 3: New Orders -->
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card card-modern bg-white h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="icon-box bg-light text-primary">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <span class="badge badge-soft-pink rounded-pill px-3 py-1">New</span>
                        </div>
                        <div class="mt-4">
                            <h6 class="text-muted mb-1">Pending Orders</h6>
                            <h2 class="font-weight-bold text-dark">{{ $pendingValidations }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card card-modern bg-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="font-weight-bold mb-0">Rental Trends</h5>
                                <small class="text-muted">Performance vs last week</small>
                            </div>
                            <button class="btn btn-sm btn-light rounded-pill px-3">Last 7 Days</button>
                        </div>
                        <div style="height: 300px; width: 100%;">
                            <canvas id="rentalTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3 px-2">
                    <h5 class="font-weight-bold mb-0">Recent Activity</h5>
                    <a href="{{ route('admin.rentals.index') }}" class="text-pink-modern font-weight-bold text-sm">View All</a>
                </div>
                
                <div class="card card-modern bg-white p-2">
                    <div class="table-responsive">
                        <table class="table table-borderless table-hover align-middle mb-0">
                            <tbody>
                                @forelse($recentRentals as $rental)
                                    <tr>
                                        <td width="60">
                                            <div class="icon-box bg-light text-pink-modern rounded-circle">
                                                <i class="fas fa-shopping-bag"></i>
                                            </div>
                                        </td>
                                        <td>
                                            <h6 class="font-weight-bold mb-0">
                                                {{ $rental->user->name }}
                                                <span class="font-weight-normal text-muted">rented</span> 
                                                {{ $rental->items->first()->asset->name ?? 'Items' }}
                                                @if($rental->items->count() > 1)
                                                    <small class="+{{ $rental->items->count() - 1 }} others">+{{ $rental->items->count() - 1 }}</small>
                                                @endif
                                            </h6>
                                            <small class="text-muted text-xs">{{ $rental->created_at->diffForHumans() }}</small>
                                        </td>
                                        <td class="text-right">
                                            <span class="badge {{ $rental->status == 'active' ? 'badge-soft-success' : ($rental->status == 'pending' ? 'badge-soft-pink' : 'badge-light') }} rounded-pill px-3 py-2">
                                                {{ ucfirst($rental->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-4">No recent activity.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('rentalTrendChart');
        if (ctx) {
            ctx = ctx.getContext('2d');
            
            // Gradient for the chart
            var gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(236, 72, 153, 0.5)'); // Pink
            gradient.addColorStop(1, 'rgba(236, 72, 153, 0.0)');

            var rentalTrendChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'], // Placeholder labels
                    datasets: [{
                        label: 'Active Rentals',
                        data: [5, 12, 19, 15, 25, 22, 30], // Placeholder data simulating a curve
                        backgroundColor: gradient,
                        borderColor: '#ec4899',
                        borderWidth: 3,
                        pointBackgroundColor: '#fff',
                        pointBorderColor: '#ec4899',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(255, 255, 255, 0.9)',
                            titleColor: '#333',
                            bodyColor: '#666',
                            borderColor: '#ddd',
                            borderWidth: 1,
                            padding: 10
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                               borderDash: [5, 5],
                               color: 'rgba(0,0,0,0.05)'
                            },
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
