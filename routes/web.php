<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CarouselsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\WelcomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [WelcomeController::class, 'welcome']);
Route::get('/products', [WelcomeController::class, 'product']);
Route::get('/stores/{id}', [WelcomeController::class, 'store']);
Route::get('/product/{slug}/{id}', [WelcomeController::class, 'detailProduct']);
// Route::get('/products/cari', [WelcomeController::class, 'cari']);
// Route::get('/home/products?category=/{id}', [WelcomeController::]);

Auth::routes(['verify' => true]);
// Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::get('/provinsi/{id}/cities', [RegisterController::class, 'getCities']);
// Route::post('/register', [RegisterController::class, 'store'])->name('register');

// Seller
Route::get('/register/{id}', [StoreController::class, 'registerSeller']);
Route::get('/provinsi/{id}/kota ', [StoreController::class, 'getCities']);
Route::patch('/register/{id}', [StoreController::class, 'storeSeller']);

Route::post('/login', [LoginController::class, 'postLogin'])->name('post-login');

Route::group(['middleware' => ['role:customer,admin,mix']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/change-password', [DashboardController::class, 'changePassword']);
    Route::patch('/update-password', [DashboardController::class, 'updatePassword'])->name('update-password');
    // Product
    Route::get('/home/products', [HomeController::class, 'indexProduct'])->name('product');
    // Toko
    Route::get('/home/stores/{id}', [HomeController::class, 'store']);
    // Product detail
    Route::get('/home/product/{slug}/{id}', [HomeController::class, 'show']);
    // konfirmasi Pembayaran
    Route::get('/konfirmasi/{id}', [HomeController::class, 'konfirmasi']);
    // Review
    Route::post('/review/{id}', [HomeController::class, 'addReview']);
    // Riwayat Pemesanan
    Route::get('/history', [HomeController::class, 'history']);
});

Route::group(['middleware' => ['role:customer,mix']], function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart/{id}', [CartController::class, 'store']);
    Route::patch('/cart/quantity/{id}', [CartController::class, 'updateQty']);
    Route::get('/cart/delete/{id}', [CartController::class, 'destroy']);
    // CheckOut
    Route::get('/checkout/{id}', [CartController::class, 'checkout']);
    // Route::post('/ongkir', [CartController::class, 'ongkir']);
    // Buat Pesanan
    Route::get('/origin={origin}&destination={destination}&weight={weight}&courier={courier}', [CartController::class, 'get_ongkir']);
    Route::get('/province/{id}/cities ', [CartController::class, 'getCities']);
    Route::patch('/checkout/form/{id}', [CartController::class, 'form']);
    // Konfirmasi Pembayaran
    Route::get('/bayar/{id}', [CartController::class, 'pembayaran']);
    Route::post('/bayar/{id}', [HomeController::class, 'uploadPemb']);
});

Route::group(['middleware' => ['role:admin,mix']], function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //category
    Route::get('/kategori', [ProductsController::class, 'kategori']);
});
Route::group(['middleware' => ['role:admin']], function () {
    // Admin
    Route::get('/admin', [AdminController::class, 'index']);
    Route::post('/admin', [AdminController::class, 'store']);
    Route::get('/customer', [AdminController::class, 'indexCust']);
    Route::delete('/customer/{id}/delete', [Admincontroller::class, 'destroy'])->name('delete-cust');
    Route::get('/store', [AdminController::class, 'indexStore']);
    Route::delete('/store/{id}/delete', [Admincontroller::class, 'destroyStore'])->name('delete-store');
    Route::get('/carousel', [CarouselsController::class, 'index']);
    Route::post('/carousel', [CarouselsController::class, 'store']);
    Route::patch('/carousel/{id}', [CarouselsController::class, 'update']);

    // category
    Route::post('/category', [ProductsController::class, 'addCategory']);
    // Product
    Route::get('/product', [ProductsController::class, 'index']);
    // Transaction
    Route::get('/transaction', [TransactionsController::class, 'index']);
    Route::get('/transaction/success', [TransactionsController::class, 'success']);
    Route::get('/transaction/failed', [TransactionsController::class, 'failed']);
    Route::post('/transaction/{id}/status', [TransactionsController::class, 'setstatus'])->name('transaction-status');
    Route::get('/transaction/{id}/detail', [TransactionsController::class, 'show'])->name('transaction-show');
    // Validasi Pembayaran
    Route::get('/pembayaran/{id}', [TransactionsController::class, 'pembayaran']);
    Route::get('/preview/{id}', [TransactionsController::class, 'getPreview']);
    Route::patch('/pembayaran/{id}', [TransactionsController::class, 'validasiPembayaran']);
    Route::patch('/pembayaran/failed/{id}', [TransactionsController::class, 'setFailed']);
});
Route::group(['middleware' => ['role:mix']], function () {
    // Dashboard
    Route::get('/dashboard/seller', [DashboardController::class, 'indexSeller']);
    // Product
    Route::get('/product/{id}', [ProductsController::class, 'indexSeller']);
    Route::post('/product', [ProductsController::class, 'store']);
    Route::patch('/product/{id}/edit', [ProductsController::class, 'update'])->name('edit-product');
    Route::delete('/product/{id}/delete', [Productscontroller::class, 'destroy'])->name('delete-product');
    Route::get('/product-gallery/{id}', [Productscontroller::class, 'show'])->name('product-gallery');
    Route::post('/gallery', [ProductsController::class, 'storeGallery']);
    Route::patch('/gallery/{id}/edit', [ProductsController::class, 'edit'])->name('edit-gallery');
    Route::delete('/gallery/{id}/delete', [ProductsController::class, 'destroyGallery'])->name('delete-gallery');
    // Transaction
    Route::get('/transaction/{id}', [TransactionsController::class, 'indexSeller'])->name('transaction-report');
    // Laporan
    Route::get('/report', [ReportsController::class, 'indexSeller']);
    // Carousel
    Route::get('/carousel/{id}', [CarouselsController::class, 'indexSeller']);
    Route::post('/carousel/{id}', [CarouselsController::class, 'storeSeller']);
    Route::patch('/carousel/seller/{id}', [CarouselsController::class, 'updateSeller']);
});
