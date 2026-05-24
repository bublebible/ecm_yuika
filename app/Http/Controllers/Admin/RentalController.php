<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rental;
use App\Models\Document;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class RentalController extends Controller
{
    public function index()
    {
        $rentals = Rental::with('user', 'items.asset')->latest()->paginate(10);
        return view('admin.rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
         $rental->load('documents', 'items.asset', 'user');
         return view('admin.rentals.show', compact('rental'));
    }

    public function update(Request $request, Rental $rental)
    {
        // Document Validation
        if ($request->has('validate_doc')) {
            $doc = Document::find($request->doc_id);
            if ($doc && $doc->rental_id == $rental->id) {
                $doc->update([
                    'status' => $request->doc_status, // valid, rejected
                    'admin_note' => $request->admin_note,
                ]);
                return back()->with('success', 'Status dokumen diperbarui.');
            }
        }

        // Rental Approval (Generate Contract)
        if ($request->has('approve_rental')) {
            // Check if identity is valid? Optional but good practice.
            $rental->update(['status' => 'approved']);
            return back()->with('success', 'Penyewaan disetujui. Kontrak siap didownload.');
        }

        // Rental Active (Barang Diambil)
        if ($request->has('start_rental')) {
            $rental->update(['status' => 'active']);
            return back()->with('success', 'Penyewaan dimulai (Barang diambil).');
        }

        // Complete & Archive
        if ($request->has('complete_rental')) {
            $rental->update(['status' => 'completed']);
            
            // Restore stock of the rented assets
            foreach ($rental->items as $item) {
                if ($item->asset) {
                    $item->asset->increment('stock_qty', $item->qty);
                }
            }

            return back()->with('success', 'Penyewaan selesai dan diarsipkan.');
        }

        return back();
    }
    
    public function downloadContract(Rental $rental)
    {
        if (!in_array($rental->status, ['approved', 'active', 'returned', 'completed'])) {
            abort(404);
        }
        $pdf = Pdf::loadView('pdfs.contract', compact('rental'));
        return $pdf->download('contract-'.$rental->id.'.pdf');
    }
}
