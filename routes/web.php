<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengaduanController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ==================== RAILWAY HEALTH CHECK ====================
Route::get('/api/health', function () {
    return response()->json([
        'status' => 'healthy',
        'timestamp' => now(),
        'service' => 'Pengaduan Masyarakat Laravel',
        'routes_available' => true
    ]);
});

Route::get('/', function () {
    return response()->json([
        'message' => 'Sistem Pengaduan Masyarakat API',
        'version' => '1.0',
        'endpoints' => [
            '/api/health' => 'Health check status',
            '/login' => 'Login pengguna',
            '/register' => 'Register pengguna',
            '/pengaduan' => 'Data pengaduan (butuh auth)'
        ],
        'documentation' => 'Sistem pengelolaan pengaduan masyarakat'
    ]);
});
// ==================== END RAILWAY HEALTH CHECK ====================

// Route yang sudah ada (DIPERBAIKI):
Route::get('/sementara2', [PetugasController::class, 'sementara']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/register', [AuthController::class, 'tampil_register']);
Route::get('/login', [AuthController::class, 'tampil_login']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/petugas-login', [PetugasController::class, 'petugas_login']);
Route::post('/petugas-login', [PetugasController::class, 'login_petugas']);

Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::get('/pengaduan', [PengaduanController::class, 'pengaduan']);
    Route::get('/home', [PengaduanController::class, 'index']);

    Route::get('/isi-pengaduan', [PengaduanController::class, 'tampil_pengaduan']);
    Route::post('/isi-pengaduan', [PengaduanController::class, 'proses_tambah_pengaduan']);
    Route::get('/isi-masyarakat', [MasyarakatController::class, 'tampil_masyarakat']);
    Route::post('/isi-masyarakat', [MasyarakatController::class, 'proses_tambah_masyarakat']);

    // FIX: ubah 'pengaduanController' menjadi 'PengaduanController'
    Route::get('/hapus-pengaduan/{id}', [PengaduanController::class, 'hapus']);
    Route::get('/hapus-petugas/{id}', [PetugasController::class, 'hapus_petugas']);
    Route::get('/detail-pengaduan/{id}', [PengaduanController::class, 'detail_pengaduan']);
    Route::post('/update-pengaduan/{id}', [PengaduanController::class, 'proses_update_pengaduan']);
    Route::get('/update-pengaduan/{id}', [PengaduanController::class, 'update_pengaduan']);
});

Route::middleware(['CekPetugas'])->group(function () {
    Route::get('/isi-petugas', [PetugasController::class, 'tampil_petugas']);
    Route::post('/isi-petugas', [PetugasController::class, 'proses_tambah_petugas']);

    Route::get('/petugas-home', [PetugasController::class, 'index']);
    Route::get('petugas-logout', [PetugasController::class, 'petugas_logout']);
    Route::post('/update-petugas/{id}', [PetugasController::class, 'proses_update_petugas']);

    Route::get('/pengaduan-petugas', [PetugasController::class, 'pengaduan']);
    Route::get('/petugas-tanggapan/{id_pengaduan}', [PetugasController::class, 'petugas_tanggapan']);
    Route::post('/petugas-tanggapan/{id_pengaduan}', [PetugasController::class, 'proses_berikan_tanggapan']);
    Route::get('/detail-tanggapan/{id_pengaduan}', [PetugasController::class, 'detail_tanggapan']);
    Route::get('/akhir-detail-tanggapan', [PetugasController::class, 'akhir-detail-tanggapan']);

    Route::get('/masyarakat', [MasyarakatController::class, 'index']);
    Route::get('/hapus-masyarakat/{nik}', [MasyarakatController::class, 'hapus']);
    Route::post('/update-masyarakat/{nik}', [MasyarakatController::class, 'proses_update_masyarakat']);
    Route::get('/update-masyarakat/{nik}', [MasyarakatController::class, 'update_masyarakat']);
});

Route::group(['middleware' => ['admin']], function () {
    Route::get('/petugas', [PetugasController::class, 'petugas']);
    Route::post('/petugas-register', [PetugasController::class, 'petugas_register']);
    Route::get('/petugas-register', [PetugasController::class, 'tampil_register_petugas']);
});
