<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\Authcontroller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;

use App\Http\Controllers\OrderAdminController;

use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;



Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// About Us Page
Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Us Page
Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/login', [Authcontroller::class, 'showLoginForm'])->name('login');
Route::post('/login', [Authcontroller::class, 'login'])->name('login.submit');
Route::get('/signup', [Authcontroller::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [Authcontroller::class, 'signup'])->name('signup.submit');
Route::post('/logout', [Authcontroller::class, 'logout'])->name('logout');
Route::get('/register', [Authcontroller::class, 'showSignupForm'])->name('register');

Route::middleware(['auth'])->prefix('admin/dashboard')->group(function () {
    // Route::get('/', function () {
    //     return view('admin.dashboard');
    // })->name('admin.dashboard');

    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

    //categoires
    Route::resource('categories', CategoryController::class)->except(['create', 'edit']);
    Route::resource('items', ItemController::class);
    Route::get('orders', function () {
        return view('admin.order');
    })->name('admin.orders');
    Route::get('orders/list', [OrderAdminController::class, 'getOrders']);
    Route::get('orders/{id}/detail', [OrderAdminController::class, 'getOrder']);
    Route::patch('orders/{id}/status', [OrderAdminController::class, 'updateStatus']);
});

Route::middleware(['auth', 'verified'])->prefix('home')->group(function () {
    Route::get('/', function () {
        $items = DB::table('items')->get();
        $categories = DB::table('categories')->get();
        $cartItems = DB::table('cart_items')
            ->join('items', 'cart_items.item_id', '=', 'items.id')
            ->where('cart_items.user_id', auth()->id())
            ->select('cart_items.*', 'items.name', 'items.image', 'items.description')
            ->get();

        return view('user.home', compact('items', 'categories', 'cartItems'));
    })->name('user.home');

    // Cart routes
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('cart.items');
        Route::post('/add', [CartController::class, 'addToCart'])->name('cart.add');
        Route::delete('/remove/{id}', [CartController::class, 'removeFromCart'])->name('cart.remove');
    });

    // About Us Page
    Route::get('/aboutus', function () {
        return view('user.userAbout');
    })->name('about-us');

    // Contact Us Page
    Route::get('/contactus', function () {
        return view('user.userContact');
    })->name('contact-us');

    // Checkout route
    Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [OrderController::class, 'processCheckout'])->name('checkout.process');
    Route::get('/order/confirmation/{id}', [OrderController::class, 'showConfirmation'])->name('order.confirmation');
});


Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

// Dashboard


// Layouts
Route::get('layout/static', 'LayoutController@static')->name('layout.static');
Route::get('layout/sidenav-light', 'LayoutController@sidenavLight')->name('layout.sidenav-light');

// Pages
Route::get('tables', 'PageController@tables')->name('tables');
Route::get('charts', 'PageController@charts')->name('charts');

// Error Pages
Route::get('error/401', 'ErrorController@unauthorized')->name('error.401');
Route::get('error/404', 'ErrorController@notFound')->name('error.404');
Route::get('error/500', 'ErrorController@serverError')->name('error.500');
