<?php

use App\Livewire\Auth\Otp;
use App\Livewire\Auth\Login;
use Illuminate\Routing\Router;
use App\Livewire\Auth\Register;
use App\Livewire\Home\HomePage;
use App\Livewire\Room\RoomPage;
use App\Livewire\Userup\UserupPage;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Account\AccountPage;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Profile\ProfilePage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Products\ProductsPage;
use App\Livewire\Dashboard\DashboardPage;
use App\Livewire\Transaction\TransactionPage;
use Illuminate\Auth\Events\Logout;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', HomePage::class)->name('home');
Route::get('login', Login::class)->name('login');
Route::get('register', Register::class)->name('register');
Route::get('forgot-password', ForgotPassword::class)->name('forgot-password');
Route::get('reset-password', ResetPassword::class)->name('reset-password.post');
Route::get('otp', Otp::class)->name('otp');
Route::get('dashboard', DashboardPage::class)->name('dashboard');
Route::get('products', ProductsPage::class)->name('products');
Route::get('room', RoomPage::class)->name('room');
Route::get('transaction', TransactionPage::class)->name('transaction');
Route::get('profile', ProfilePage::class)->name('profile');
Route::get('account', AccountPage::class)->name('account');
Route::get('userup', UserupPage::class)->name('userup');
Route::get('resend-otp', Otp::class)->name('resend-otp');
Route::get('logout', Login::class)->name('logout');
// Route::get('resend-otp');
