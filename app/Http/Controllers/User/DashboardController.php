<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // New Arrivals: Latest 5 assets
        $newArrivals = Asset::with(['latestCondition', 'category'])->latest()->take(5)->get();

        // Popular: Random 4 for now (or based on rental count if available)
        $popularAssets = Asset::with(['latestCondition', 'category'])->inRandomOrder()->take(4)->get();

        // Approved testimonials with user eager loaded (latest 6)
        $testimonials = Testimonial::with('user')
            ->where('is_approved', true)
            ->latest()
            ->take(6)
            ->get();

        return view('dashboard', compact('newArrivals', 'popularAssets', 'testimonials'));
    }
}
