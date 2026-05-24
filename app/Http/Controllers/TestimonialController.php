<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Store a new testimonial for a completed rental.
     */
    public function store(Request $request)
    {
        $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'rating'    => 'required|integer|min:1|max:5',
            'comment'   => 'required|string|min:5|max:1000',
        ]);

        $rental = Rental::findOrFail($request->rental_id);

        // Ensure the rental belongs to the authenticated user
        if ($rental->user_id !== Auth::id()) {
            abort(403, 'Unauthorized.');
        }

        // Ensure rental is completed
        if ($rental->status !== 'completed') {
            return back()->with('error', 'Testimoni hanya dapat diberikan untuk sewa yang sudah selesai.');
        }

        // Prevent duplicate testimonials for same rental
        if ($rental->testimonial) {
            return back()->with('error', 'Kamu sudah memberikan testimoni untuk sewa ini.');
        }

        Testimonial::create([
            'user_id'     => Auth::id(),
            'rental_id'   => $rental->id,
            'rating'      => $request->rating,
            'comment'     => $request->comment,
            'is_approved' => true,
        ]);

        return back()->with('success', 'Terima kasih atas testimonimu! 🎉');
    }
}
