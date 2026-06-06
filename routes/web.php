<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

Route::get('/dashboard', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/ktp', [ProfileController::class, 'uploadKtp'])->name('profile.upload_ktp');

    // Testimonials
    Route::post('/testimonials', [TestimonialController::class, 'store'])->name('testimonials.store');

    // Payment
    Route::post('/rentals/{rental}/pay', [PaymentController::class, 'createSnap'])->name('payment.snap');
    Route::post('/rentals/{rental}/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
    Route::get('/payment/finish', [PaymentController::class, 'finish'])->name('payment.finish');
    Route::post('/rentals/{rental}/pay-success-local', [PaymentController::class, 'successLocal'])->name('payment.success_local');

    // User Routes
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/history', [App\Http\Controllers\User\HistoryController::class, 'index'])->name('history.index');
        Route::patch('/rentals/{rental}/return', [App\Http\Controllers\User\RentalController::class, 'returnItem'])->name('rentals.return');
        // rentals.index redirects to history — same page now
        Route::get('/rentals', fn() => redirect()->route('user.history.index'))->name('rentals.index');
        Route::resource('rentals', App\Http\Controllers\User\RentalController::class)->only(['create', 'store', 'update', 'edit']);
        Route::get('/rentals/{rental}/contract', [App\Http\Controllers\User\RentalController::class, 'downloadContract'])->name('rentals.contract');

        // Cart Checkout
        Route::post('/checkout', [App\Http\Controllers\User\CartController::class, 'checkout'])->name('cart.checkout');

        // Messages
        Route::get('/messages', [App\Http\Controllers\MessageController::class, 'userIndex'])->name('messages.index');
        Route::get('/messages/fetch', [App\Http\Controllers\MessageController::class, 'userFetch'])->name('messages.fetch');
        Route::get('/messages/unread', [App\Http\Controllers\MessageController::class, 'userUnreadCount'])->name('messages.unread');
        Route::post('/messages/send', [App\Http\Controllers\MessageController::class, 'userSend'])->name('messages.send');
        Route::post('/messages/chatbot', [App\Http\Controllers\MessageController::class, 'userChatbot'])->name('messages.chatbot');
        Route::post('/messages/typing', [App\Http\Controllers\MessageController::class, 'userTyping'])->name('messages.typing');
    });

    // Admin Routes
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => function ($request, $next) {
        if (! $request->user()->isAdmin()) {
            abort(403);
        }
        return $next($request);
    }], function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        // KTP Verification
        Route::get('/ktp', [App\Http\Controllers\Admin\KtpVerificationController::class, 'index'])->name('ktp.index');
        Route::post('/ktp/{user}/verify', [App\Http\Controllers\Admin\KtpVerificationController::class, 'verify'])->name('ktp.verify');
        Route::post('/ktp/{user}/reject', [App\Http\Controllers\Admin\KtpVerificationController::class, 'reject'])->name('ktp.reject');

        // Inventory (Assets)
        Route::resource('assets', App\Http\Controllers\Admin\AssetController::class);
        
        // Orders (Rentals)
        Route::resource('rentals', App\Http\Controllers\Admin\RentalController::class)->only(['index', 'update', 'show']);
        Route::get('/rentals/{rental}/contract', [App\Http\Controllers\Admin\RentalController::class, 'downloadContract'])->name('rentals.contract');
        
        // Reports
        Route::get('/reports', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('reports.index');
        
        // Content Manage
        Route::resource('content', App\Http\Controllers\Admin\ContentController::class)->parameters(['content' => 'content']);
        
        // Categories
        Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);

        // Admin Messages
        Route::get('/messages', [App\Http\Controllers\MessageController::class, 'adminIndex'])->name('messages.index');
        Route::get('/messages/fetch/{user}', [App\Http\Controllers\MessageController::class, 'adminFetch'])->name('messages.fetch');
        Route::post('/messages/send', [App\Http\Controllers\MessageController::class, 'adminSend'])->name('messages.send');
        Route::get('/messages/unread', [App\Http\Controllers\MessageController::class, 'adminUnreadCount'])->name('messages.unread');
        Route::post('/messages/typing', [App\Http\Controllers\MessageController::class, 'adminTyping'])->name('messages.typing');
        Route::post('/messages/clear', [App\Http\Controllers\MessageController::class, 'clearChat'])->name('messages.clear');
    });
});

// Public User Routes
Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/catalog', [App\Http\Controllers\User\CatalogController::class, 'index'])->name('catalog.index');
    Route::get('/catalog/{asset}', [App\Http\Controllers\User\CatalogController::class, 'show'])->name('catalog.show');
    Route::get('/blog', [App\Http\Controllers\User\BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/{post:slug}', [App\Http\Controllers\User\BlogController::class, 'show'])->name('blog.show');

    // Cart (Public viewing, adding, updating, removing)
    Route::get('/cart', [App\Http\Controllers\User\CartController::class, 'index'])->name('cart.index');
    Route::get('/add-to-cart/{id}', [App\Http\Controllers\User\CartController::class, 'addToCart'])->name('cart.add');
    Route::patch('/update-cart', [App\Http\Controllers\User\CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove-from-cart', [App\Http\Controllers\User\CartController::class, 'remove'])->name('cart.remove');
});

// Public Routes
Route::get('/about', function () {
    return view('about');
})->name('about');

// Midtrans Webhook — no auth, Midtrans server calls this directly
Route::post('/payment/notification', [PaymentController::class, 'notification'])
    ->name('payment.notification')
    ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);

require __DIR__.'/auth.php';
