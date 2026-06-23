<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Rental;
use App\Models\Document;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAssets = Asset::sum('stock_qty');
        $totalRentals = Rental::count();
        $activeRentals = Rental::where('status', 'active')->count();
        
        // Pending Validations (Pending documents)
        $pendingValidations = Document::where('status', 'pending')->count();
        
        // Recent Rentals
        $recentRentals = Rental::with('user')->latest()->take(5)->get();

        // Rental trends data (last 7 days)
        $days = [];
        $rentalCounts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days[] = $date->format('D'); // e.g. Mon, Tue, etc.
            
            // Count rentals created on this specific date
            $rentalCounts[] = Rental::whereDate('created_at', $date->toDateString())->count();
        }

        return view('admin.dashboard.index', compact(
            'totalAssets', 
            'totalRentals', 
            'activeRentals', 
            'pendingValidations',
            'recentRentals',
            'days',
            'rentalCounts'
        ));
    }
}
