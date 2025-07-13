<?php

use App\Livewire\Auth\Otp;
use App\Livewire\Room\Room;
use App\Livewire\Auth\Login;
use Illuminate\Routing\Router;
use App\Livewire\Auth\Register;
use App\Livewire\Home\HomePage;
use App\Livewire\Room\RoomForm;
use App\Livewire\Room\RoomPage;
use App\Livewire\Actions\Logout;
use App\Livewire\Profile\DataUser;
use App\Livewire\Profile\Password;
use App\Livewire\Room\LiveBidding;
use App\Livewire\Userup\UserupPage;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Account\AccountPage;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Products\ProductAdd;
use App\Livewire\Profile\ProfilePage;
use App\Livewire\Room\ManageRoomPage;
use Illuminate\Support\Facades\Route;
use App\Livewire\Products\ProductForm;
use App\Livewire\Account\AccountDetail;
use App\Livewire\Category\CategoryPage;
use App\Livewire\Products\ProductsPage;
use App\Livewire\Products\ProductDetail;
use App\Livewire\Dashboard\DashboardPage;
use App\Livewire\Transaction\TransactionForm;
use App\Livewire\Transaction\TransactionPage;
use App\Livewire\Transaction\ManageTransactionPage;

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
    Route::get('profile/profile', ProfilePage::class)->name('profile');
    Route::get('profile/userdata', DataUser::class)->name('profile.data');
    Route::get('profile/password', Password::class)->name('profile.password');
    Route::get('logout', Logout::class)->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('products', ProductsPage::class)->name('products');
    Route::get('product/create', ProductForm::class)->name('product.create');
    Route::get('product/{id}/detailmanage', ProductForm::class)->name('product.edit');
});

Route::get('room/{coderoom}/detail', Room::class)->name('room.detail');
Route::middleware('auth')->group(function () {
    Route::get('room', RoomPage::class)->name('room');
    Route::get('rooms', ManageRoomPage::class)->name('rooms');
    Route::get('room/create', RoomForm::class)->name('room.create');
    Route::get('room/{coderoom}/detailmanage', RoomForm::class)->name('room.edit');
    Route::get('room/{coderoom}/roombidding', LiveBidding::class)->name('room.bidding');
});

Route::middleware('auth')->group(function () {
    Route::get('accounts', AccountPage::class)->name('accounts');
    Route::get('account/{usercode}/edit', AccountDetail::class)->name('account.edit');
});

Route::middleware('auth')->group(function () {
    Route::get('transaction', TransactionPage::class)->name('transaction');
    Route::get('transactions', ManageTransactionPage::class)->name('transaction.manage');
    Route::get('transaction/{codetransaksi}/detail', TransactionForm::class)->name('transaction.detail');
});
