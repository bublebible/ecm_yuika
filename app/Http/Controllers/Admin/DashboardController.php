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

        return view('admin.dashboard.index', compact(
            'totalAssets', 
            'totalRentals', 
            'activeRentals', 
            'pendingValidations',
            'recentRentals'
        ));
    }
}
