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

    public function export(Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $rentals = Rental::with(['user', 'items.asset'])
                         ->whereBetween('start_date', [$startDate, $endDate])
                         ->whereIn('status', ['completed', 'active', 'returned'])
                         ->get();

        $rows = [
            ['Laporan Penyewaan Kostum Yuika Cosplay'],
            ['Periode:', $startDate . ' s/d ' . $endDate],
            [],
            ['ID Transaksi', 'Tanggal Transaksi', 'Nama Pelanggan', 'Email Pelanggan', 'Kostum Yang Disewa', 'Tanggal Mulai', 'Tanggal Selesai', 'Total Harga', 'Status']
        ];

        foreach ($rentals as $rental) {
            $costumes = $rental->items->map(function($item) {
                return $item->asset ? $item->asset->name : 'N/A';
            })->implode(', ');

            $rows[] = [
                '#' . $rental->id,
                $rental->created_at->format('Y-m-d H:i:s'),
                $rental->user->name,
                $rental->user->email,
                $costumes,
                $rental->start_date,
                $rental->end_date,
                $rental->total_price,
                ucfirst($rental->status)
            ];
        }

        $xlsx = \Shuchkin\SimpleXLSXGen::fromArray($rows);

        return response((string) $xlsx, 200, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="laporan-sewa-' . $startDate . '-to-' . $endDate . '.xlsx"',
            'Cache-Control' => 'max-age=0',
        ]);
    }
}
