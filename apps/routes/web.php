<?php

use App\Livewire\Auth\Otp;
use App\Livewire\Auth\Login;
use Illuminate\Routing\Router;
use App\Livewire\Actions\Logout;
use App\Livewire\Auth\Register;
use App\Livewire\Home\HomePage;
use App\Livewire\Room\RoomPage;
use App\Livewire\Userup\UserupPage;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Account\AccountPage;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Category\CategoryPage;
use App\Livewire\Profile\ProfilePage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Products\ProductsPage;
use App\Livewire\Dashboard\DashboardPage;
use App\Livewire\Products\ProductAdd;
use App\Livewire\Products\ProductDetail;
use App\Livewire\Profile\DataUser;
use App\Livewire\Profile\Password;
use App\Livewire\Room\ManageRoomPage;
use App\Livewire\Transaction\TransactionPage;

Route::get('/', HomePage::class)->name('home');
Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::post('alogin', Login::class)->name('alogin');
    Route::get('register', Register::class)->name('register');
    Route::get('forgot-password', ForgotPassword::class)->name('forgot-password');
    Route::get('reset-password', ResetPassword::class)->name('reset-password.post');
    Route::get('reset-password/{token}', ResetPassword::class)->name('password.reset');
    Route::get('otp', Otp::class)->name('otp');
    Route::get('resend-otp', Otp::class)->name('resend-otp');
});
Route::middleware('auth')->group(function () {
    Route::get('dashboard', DashboardPage::class)->name('dashboard');

    Route::get('room', RoomPage::class)->name('room');
    Route::get('transaction', TransactionPage::class)->name('transaction');
    Route::get('account', AccountPage::class)->name('account');
    Route::get('userup', UserupPage::class)->name('userup');
    Route::get('category', CategoryPage::class)->name('category');

    Route::get('profile/profile', ProfilePage::class)->name('profile');
    Route::get('profile/userdata', DataUser::class)->name('profile.data');
    Route::get('profile/password', Password::class)->name('profile.password');

    Route::get('logout', Logout::class)->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('room/manage', ManageRoomPage::class)->name('room.manage');
    Route::get('room/manage/partisipan', ManageRoomPage::class)->name('room.manage.partisipan');
    Route::get('products', ProductsPage::class)->name('products');
    Route::get('products/create', ProductAdd::class)->name('product.create');
    Route::get('products/detail/{id}', ProductDetail::class)->name('product.detail');

});







// Route::post('logout', App\Livewire\Actions\Logout::class)
//     ->name('logout');
// Route::get('resend-otp');
