<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\User\DashboardController::class, 'index'])->name('dashboard');

Route::get('/dashboard', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Routes
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('/catalog', [App\Http\Controllers\User\CatalogController::class, 'index'])->name('catalog.index');
        Route::get('/blog', [App\Http\Controllers\User\BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/{post:slug}', [App\Http\Controllers\User\BlogController::class, 'show'])->name('blog.show');
        Route::get('/history', [App\Http\Controllers\User\HistoryController::class, 'index'])->name('history.index');
        Route::patch('/rentals/{rental}/return', [App\Http\Controllers\User\RentalController::class, 'returnItem'])->name('rentals.return');
        Route::resource('rentals', App\Http\Controllers\User\RentalController::class)->only(['index', 'create', 'store', 'update', 'edit']);
        Route::get('/rentals/{rental}/contract', [App\Http\Controllers\User\RentalController::class, 'downloadContract'])->name('rentals.contract');

        // Cart
        Route::get('/cart', [App\Http\Controllers\User\CartController::class, 'index'])->name('cart.index');
        Route::get('/add-to-cart/{id}', [App\Http\Controllers\User\CartController::class, 'addToCart'])->name('cart.add');
        Route::patch('/update-cart', [App\Http\Controllers\User\CartController::class, 'update'])->name('cart.update');
        Route::delete('/remove-from-cart', [App\Http\Controllers\User\CartController::class, 'remove'])->name('cart.remove');
        Route::post('/checkout', [App\Http\Controllers\User\CartController::class, 'checkout'])->name('cart.checkout');

        // Messages
        Route::get('/messages', function () {
            return view('user.messages.index');
        })->name('messages.index');
    });

    // Admin Routes
    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => function ($request, $next) {
        if (! $request->user()->isAdmin()) {
            abort(403);
        }
        return $next($request);
    }], function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
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
    });
});

// Public Routes
Route::get('/about', function () {
    return view('about');
})->name('about');

require __DIR__.'/auth.php';
