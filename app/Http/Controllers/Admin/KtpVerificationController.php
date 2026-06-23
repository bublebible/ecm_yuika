<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class KtpVerificationController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');
        
        $query = User::where('role', 'customer');
            
        if ($status === 'pending') {
            $query->where('ktp_status', 'pending');
        } elseif ($status === 'verified') {
            $query->where('ktp_status', 'verified');
        } elseif ($status === 'rejected') {
            $query->where('ktp_status', 'rejected');
        } else {
            // Show all who have uploaded or tried to upload KTP
            $query->whereNotNull('ktp_image');
        }
        
        $users = $query->latest()->paginate(10);
        
        return view('admin.ktp.index', compact('users', 'status'));
    }

    public function verify(User $user)
    {
        \Log::info('Verifying KTP for user: ' . $user->id . ' - current status: ' . $user->ktp_status);
        $result = $user->update([
            'ktp_status' => 'verified',
            'ktp_rejection_reason' => null
        ]);
        \Log::info('Verification result: ' . ($result ? 'true' : 'false') . ' - new status: ' . $user->ktp_status . ' - fresh status: ' . $user->fresh()->ktp_status);

        return back()->with('success', "KTP milik {$user->name} berhasil diverifikasi.");
    }

    public function reject(Request $request, User $user)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $user->update([
            'ktp_status' => 'rejected',
            'ktp_rejection_reason' => $request->rejection_reason
        ]);

        return back()->with('success', "Verifikasi KTP {$user->name} ditolak.");
    }
}
