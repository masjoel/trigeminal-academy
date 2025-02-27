<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AutoNumberController;
use App\Http\Controllers\BackupDataController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Backend\DesaController;
use App\Http\Controllers\Frontend\FotoController;
use App\Http\Controllers\Frontend\VideoController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\StudentController;
use App\Http\Controllers\Frontend\ArtikelController;
use App\Http\Controllers\Frontend\HalamanController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Backend\InstructorController;
use App\Http\Controllers\Backend\LinkExternalController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Frontend\SlidebannerController;
use App\Http\Controllers\Frontend\ProfilBisnisController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Frontend\ProductFrontendController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('about', [HomeController::class, 'about'])->name('about');
Route::get('kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::get('visi-misi', [HomeController::class, 'visimisi'])->name('visimisi');
Route::get('sejarah', [HomeController::class, 'sejarah'])->name('sejarah');
Route::get('galery', [HomeController::class, 'galery'])->name('galery');
Route::get('blog', [BlogController::class, 'index'])->name('blog');
Route::post('blog', [BlogController::class, 'index']);
Route::get('blog/{varpost:slug}', [BlogController::class, 'show']);
Route::get('blog/category/{slug}', [BlogController::class, 'index'])->name('blog.category');
Route::get('autonumbers', [AutoNumberController::class, 'get']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', function () {
        return view('backend.profile');
    })->name('profile.edit');
    Route::resource('user', UserController::class);
    Route::get('user/{user}/permission', [UserController::class, 'permission'])->name('user.permission');
    Route::put('user-permision/{user}', [UserController::class, 'updatepermission'])->name('user.updatepermission');

    Route::resource('profil-bisnis', DesaController::class);
    Route::resource('link', LinkExternalController::class);
    Route::resource('backup-data', BackupDataController::class);
    Route::controller(BackupDataController::class)->group(function () {
        Route::get('restore-data', 'restore')->name('restore-data');
        Route::get('download-db/{file}', 'download')->name('download-db');
        Route::post('upload-db', 'upload')->name('upload-db');
    });
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('profil-user', ProfilBisnisController::class);
    Route::resource('halaman', HalamanController::class);
    Route::resource('artikel', ArtikelController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('slidebanner', SlidebannerController::class);
    Route::resource('galeri-foto', FotoController::class);
    Route::resource('galeri-video', VideoController::class);
    Route::resource('student', StudentController::class);
    Route::resource('course', ProductController::class);
    Route::resource('kategori-kursus', ProductCategoryController::class);
    Route::resource('instruktur', InstructorController::class);
    Route::resource('order', OrderController::class);
    Route::get('/export-peserta/{product_id}', [StudentController::class, 'exportCustomer']);
    Route::get('/lihat-peserta/{product_id}', [ProductController::class, 'lihatPeserta'])->name('lihat-peserta');
});

Route::get('/example-product-detail', [HomeController::class, 'exampleProductDetail'])->name('example-product-detail');
Route::get('/kelas', [ProductFrontendController::class, 'index'])->name('list-kelas');
Route::get('/kelas/{slug}', [ProductFrontendController::class, 'show'])->name('product.show');
Route::get('/data/kelas/process', [ProductFrontendController::class, 'process'])->name('class.process');
Route::post('/data/kelas/keranjang', [ProductFrontendController::class, 'keranjang'])->name('keranjang');
Route::post('aktivasi', [DesaController::class, 'aktivasi'])->name('aktivasi');
Route::get('/detail-kelas/{slug}', [HomeController::class, 'detailKelas'])->name('detail-kelas');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/success', [CheckoutController::class, 'checkoutSuccess'])->name('checkout.success');
Route::get('/konfirmasi-pembayaran/{id}', [OrderController::class, 'konfirmasiPembayaran']);
Route::post('/konfirmasi-pembayaran', [OrderController::class, 'konfirmasiPembayaranSuccess'])->name('konfirmasi.pembayaran');
