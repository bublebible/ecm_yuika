<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Rental;

class HistoryController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Active: Pending, Approved, Active
        $activeRentals = Rental::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved', 'active'])
            ->with(['items.asset.latestCondition', 'items.asset.category'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Past: Returned, Completed, Cancelled
        $pastRentals = Rental::where('user_id', $user->id)
            ->whereIn('status', ['returned', 'completed', 'cancelled'])
            ->with(['items.asset.latestCondition', 'items.asset.category'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.history.index', compact('activeRentals', 'pastRentals'));
    }
}
