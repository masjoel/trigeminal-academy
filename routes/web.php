<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\Api\NikController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AutoNumberController;
use App\Http\Controllers\BackupDataController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\Backend\DesaController;
use App\Http\Controllers\Frontend\FotoController;
use App\Http\Controllers\Frontend\VideoController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Frontend\ArtikelController;
use App\Http\Controllers\Frontend\HalamanController;
use App\Http\Controllers\Frontend\BukuTamuController;
use App\Http\Controllers\Frontend\CategoryController;
use App\Http\Controllers\Frontend\StrukturOrganisasi;
use App\Http\Controllers\Backend\LinkExternalController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Frontend\SlidebannerController;
use App\Http\Controllers\Frontend\ProfilBisnisController;
use App\Http\Controllers\Frontend\PerangkatDesaController;
use App\Http\Controllers\Backend\InstructorController;
use App\Http\Controllers\Backend\StudentController;
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
Route::get('/example-product-detail', [HomeController::class, 'exampleProductDetail'])->name('example-product-detail');
Route::get('/kelas', [ProductFrontendController::class, 'index'])->name('product.index');
Route::get('/kelas/{slug}', [ProductFrontendController::class, 'show'])->name('product.show');
Route::get('/data/kelas/process', [ProductFrontendController::class, 'process'])->name('class.process');
Route::post('/data/kelas/keranjang', [ProductFrontendController::class, 'keranjang'])->name('keranjang');

// Route::get('/login', [HomeController::class, 'login']);
Route::get('about', [HomeController::class, 'about'])->name('about');
Route::get('kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::get('cek-status-anggota', [HomeController::class, 'cekAnggota'])->name('cek-status-anggota');
Route::get('status-anggota/{nik}', [HomeController::class, 'statusAnggota'])->name('status-anggota');
Route::get('form-registrasi', [HomeController::class, 'registrasi'])->name('form-registrasi');
Route::post('form-registrasi', [HomeController::class, 'storeRegistrasi'])->name('form-registrasi.store');
Route::get('visi-misi', [HomeController::class, 'visimisi'])->name('visimisi');
Route::get('sejarah', [HomeController::class, 'sejarah'])->name('sejarah');
Route::get('geografis', [HomeController::class, 'geografis'])->name('geografis');
Route::get('demografi', [HomeController::class, 'demografi'])->name('demografi');
Route::get('struktur-organisasi', [HomeController::class, 'sotk'])->name('sotk');
Route::get('anggota-pengurus', [HomeController::class, 'perangkat'])->name('perangkat');
Route::get('anggota-pengurus/{varpost:slug}', [HomeController::class, 'perangkatdetail'])->name('perangkatdetail');
Route::get('lembaga-desa', [HomeController::class, 'lembaga'])->name('lembaga');
Route::get('galery', [HomeController::class, 'galery'])->name('galery');
Route::get('blog', [BlogController::class, 'index'])->name('blog');
Route::post('blog', [BlogController::class, 'index']);
Route::get('blog/{varpost:slug}', [BlogController::class, 'show']);
Route::get('blog/category/{slug}', [BlogController::class, 'index'])->name('blog.category');
Route::get('/ceknik', [NikController::class, 'index'])->name('ceknik');
Route::get('autonumbers', [AutoNumberController::class, 'get']);

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('x', function () {
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
    Route::resource('admin-struktur-organisasi', StrukturOrganisasi::class);
    Route::resource('admin-pengurus', PerangkatDesaController::class);
    // Route::resource('admin-anggota', AnggotaController::class);
    Route::resource('student', StudentController::class);
    Route::resource('course', ProductController::class);
    Route::resource('kategori-kursus', ProductCategoryController::class);
    Route::resource('instruktur', InstructorController::class);
});
Route::post('aktivasi', [DesaController::class, 'aktivasi'])->name('aktivasi');
Route::get('/detail-kelas/{slug}', [HomeController::class, 'detailKelas'])->name('detail-kelas');
