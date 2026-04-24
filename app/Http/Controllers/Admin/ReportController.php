<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $rentals = Rental::whereBetween('start_date', [$startDate, $endDate])
                         ->whereIn('status', ['completed', 'active', 'returned'])
                         ->get();

        $totalRevenue = $rentals->sum('total_price');
        $totalTransactions = $rentals->count();

        return view('admin.reports.index', compact('rentals', 'totalRevenue', 'totalTransactions', 'startDate', 'endDate'));
    }
}
