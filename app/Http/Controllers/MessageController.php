<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MessageController extends Controller
{
    /**
     * User Chat Page
     */
    public function userIndex()
    {
        $userId = Auth::id();
        $admin = User::where('role', 'admin')->first();
        $lastMessage = null;
        if ($admin) {
            $lastMessage = Message::where(function ($query) use ($userId, $admin) {
                $query->where('sender_id', $userId)->where('receiver_id', $admin->id);
            })->orWhere(function ($query) use ($userId, $admin) {
                $query->where('sender_id', $admin->id)->where('receiver_id', $userId);
            })->latest()->first();
        }

        return view('user.messages.index', compact('lastMessage'));
    }

    /**
     * Fetch user messages
     */
    public function userFetch()
    {
        $userId = Auth::id();
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            return response()->json(['messages' => [], 'is_typing' => false]);
        }

        // Auto-purge old messages (older than 24 hours)
        Message::where('created_at', '<', now()->subHours(24))->delete();

        $messages = Message::where(function ($query) use ($userId, $admin) {
            $query->where('sender_id', $userId)->where('receiver_id', $admin->id);
        })->orWhere(function ($query) use ($userId, $admin) {
            $query->where('sender_id', $admin->id)->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        // Mark as read
        Message::where('sender_id', $admin->id)->where('receiver_id', $userId)->update(['is_read' => true]);

        // Check if admin is typing to user
        $isTyping = Cache::has("typing-from-{$admin->id}-to-{$userId}");

        return response()->json([
            'messages' => $messages,
            'is_typing' => $isTyping
        ]);
    }

    /**
     * User send message
     */
    public function userSend(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $userId = Auth::id();
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            return response()->json(['error' => 'No admin found'], 404);
        }

        $message = Message::create([
            'sender_id' => $userId,
            'receiver_id' => $admin->id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        // Auto-reply logic if admin is offline
        if (!Cache::has("admin-online")) {
            $rateLimitKey = "auto-reply-sent-to-{$userId}";
            if (!Cache::has($rateLimitKey)) {
                // Send auto-reply message from admin to user
                Message::create([
                    'sender_id' => $admin->id,
                    'receiver_id' => $userId,
                    'message' => 'Halo kak! Maaf ya admin sedang offline saat ini. Silakan tinggalkan pertanyaan atau pesan kakak terlebih dahulu, nanti segera setelah admin aktif kembali akan langsung kami balas ya. Terima kasih kak! 😊✨',
                    'is_read' => false,
                ]);

                // Limit auto-reply to once every 15 minutes per user
                Cache::put($rateLimitKey, true, now()->addMinutes(15));
            }
        }

        return response()->json($message);
    }

    /**
     * Get unread message count for the current user (from admin)
     */
    public function userUnreadCount()
    {
        $userId = Auth::id();
        $admin  = User::where('role', 'admin')->first();

        if (!$admin) {
            return response()->json(['count' => 0]);
        }

        $count = Message::where('sender_id', $admin->id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json(['count' => $count]);
    }


    /**
     * Admin Chat Page
     */
    public function adminIndex(Request $request)
    {
        $adminId = Auth::id();
        // Update admin online cache status
        Cache::put("admin-online", true, now()->addSeconds(35));

        $users = User::where('role', '!=', 'admin')->get()->map(function($user) use ($adminId) {
            $lastMessage = Message::where(function($q) use ($user, $adminId) {
                $q->where('sender_id', $user->id)->where('receiver_id', $adminId);
            })->orWhere(function($q) use ($user, $adminId) {
                $q->where('sender_id', $adminId)->where('receiver_id', $user->id);
            })->latest()->first();

            $user->last_message = $lastMessage ? $lastMessage->message : 'No messages yet';
            $user->last_message_time = $lastMessage ? $lastMessage->created_at->format('h:i A') : '';
            $user->unread_count = Message::where('sender_id', $user->id)->where('receiver_id', $adminId)->where('is_read', false)->count();
            return $user;
        });

        if ($request->ajax()) {
            return response()->json($users);
        }

        return view('admin.messages.index', compact('users'));
    }

    /**
     * Admin fetch messages for a specific user
     */
    public function adminFetch($userId)
    {
        $adminId = Auth::id();
        // Update admin online cache status
        Cache::put("admin-online", true, now()->addSeconds(35));

        // Auto-purge old messages (older than 24 hours)
        Message::where('created_at', '<', now()->subHours(24))->delete();
        
        $messages = Message::where(function ($query) use ($userId, $adminId) {
            $query->where('sender_id', $userId)->where('receiver_id', $adminId);
        })->orWhere(function ($query) use ($userId, $adminId) {
            $query->where('sender_id', $adminId)->where('receiver_id', $userId);
        })->orderBy('created_at', 'asc')->get();

        // Mark as read
        Message::where('sender_id', $userId)->where('receiver_id', $adminId)->update(['is_read' => true]);

        // Check if user is typing to admin
        $isTyping = Cache::has("typing-from-{$userId}-to-{$adminId}");

        return response()->json([
            'messages' => $messages,
            'is_typing' => $isTyping
        ]);
    }

    /**
     * Admin send message
     */
    public function adminSend(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer',
            'message' => 'required|string',
        ]);

        $adminId = Auth::id();
        // Update admin online cache status
        Cache::put("admin-online", true, now()->addSeconds(35));
        
        $message = Message::create([
            'sender_id' => $adminId,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return response()->json($message);
    }

    /**
     * Admin check unread messages count
     */
    public function adminUnreadCount()
    {
        $adminId = Auth::id();
        $count = Message::where('receiver_id', $adminId)->where('is_read', false)->count();
        return response()->json(['count' => $count]);
    }

    /**
     * Customer chatbot interaction
     */
    public function userChatbot(Request $request)
    {
        $request->validate([
            'action' => 'required|string|in:rent_flow,rental_status,pricing,location',
        ]);

        $userId = Auth::id();
        $admin = User::where('role', 'admin')->first();
        if (!$admin) {
            return response()->json(['error' => 'No admin found'], 404);
        }

        $userQuestion = '';
        $botReply = '';

        switch ($request->action) {
            case 'rent_flow':
                $userQuestion = '❓ Cara Pinjam Kostum';
                $botReply = "Berikut adalah langkah penyewaan kostum di YUMICOS:\n1. Pilih kostum favorit Anda di menu Katalog.\n2. Klik 'Rent Now' dan tentukan tanggal peminjaman (durasi sewa standar 3 hari).\n3. Lakukan pembayaran via Transfer Bank / E-Wallet dan unggah bukti transfer.\n4. Admin akan memverifikasi orderan Anda, dan kostum siap dikirim atau diambil di toko!";
                break;

            case 'rental_status':
                $userQuestion = '📦 Cek Status Rental';
                
                $latestRental = \App\Models\Rental::where('user_id', $userId)->latest()->first();
                
                if ($latestRental) {
                    $firstItem = $latestRental->items()->first();
                    $costumeName = ($firstItem && $firstItem->asset) ? $firstItem->asset->name : 'Kostum';
                    $status = strtoupper($latestRental->status);
                    
                    $botReply = "Status rental terakhir Anda:\n\nOrder ID: #{$latestRental->id}\nKostum: {$costumeName}\nStatus: {$status}\nTanggal Sewa: " . ($latestRental->start_date ? $latestRental->start_date->format('d M Y') : '-') . " s/d " . ($latestRental->end_date ? $latestRental->end_date->format('d M Y') : '-') . ".\n\nSilakan cek menu History untuk detail selengkapnya.";
                } else {
                    $botReply = "Saat ini Anda belum memiliki riwayat rental kostum di YUMICOS. Yuk jelajahi Katalog kami!";
                }
                break;

            case 'pricing':
                $userQuestion = '💰 Informasi Harga & Denda';
                $botReply = "Berikut detail ketentuan biaya di YUMICOS:\n- Durasi sewa standar: 3 hari sejak tanggal pengambilan/penerimaan.\n- Harga sewa: Beragam tergantung kostum (tertera di katalog).\n- Denda keterlambatan: Rp 25.000,- per hari demi kenyamanan penyewa berikutnya.\n- Kerusakan/kehilangan: Dikenakan biaya perbaikan/penggantian sesuai tingkat kerusakan.";
                break;

            case 'location':
                $userQuestion = '📍 Lokasi Toko & Kontak';
                $botReply = "📍 Lokasi Toko YUMICOS:\nJl. Yuika Rentcos No. 12, Kebayoran Baru, Jakarta Selatan\n\n⏰ Jam Operasional:\nSetiap hari, 10:00 - 20:00 WIB\n\n📞 Kontak WhatsApp: +62 812-3456-7890";
                break;
        }

        // 1. Create message for user question
        $userMsg = Message::create([
            'sender_id' => $userId,
            'receiver_id' => $admin->id,
            'message' => $userQuestion,
            'is_read' => true,
        ]);

        // 2. Create message for chatbot reply (from admin to user)
        $botMsg = Message::create([
            'sender_id' => $admin->id,
            'receiver_id' => $userId,
            'message' => $botReply,
            'is_read' => false,
        ]);

        return response()->json([
            'user_message' => $userMsg,
            'bot_message' => $botMsg
        ]);
    }

    /**
     * Set user typing status
     */
    public function userTyping()
    {
        $userId = Auth::id();
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            Cache::put("typing-from-{$userId}-to-{$admin->id}", true, now()->addSeconds(4));
        }
        return response()->json(['status' => 'success']);
    }

    /**
     * Set admin typing status
     */
    public function adminTyping(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer'
        ]);

        $adminId = Auth::id();
        // Update admin online cache status
        Cache::put("admin-online", true, now()->addSeconds(35));

        Cache::put("typing-from-{$adminId}-to-{$request->receiver_id}", true, now()->addSeconds(4));

        return response()->json(['status' => 'success']);
    }

    /**
     * Clear all message logs between admin and a specific user
     */
    public function clearChat(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer'
        ]);

        $adminId = Auth::id();
        $userId = $request->user_id;

        Message::where(function ($query) use ($adminId, $userId) {
            $query->where('sender_id', $adminId)->where('receiver_id', $userId);
        })->orWhere(function ($query) use ($adminId, $userId) {
            $query->where('sender_id', $userId)->where('receiver_id', $adminId);
        })->delete();

        return response()->json(['status' => 'success', 'message' => 'Chat history cleared successfully']);
    }
}
