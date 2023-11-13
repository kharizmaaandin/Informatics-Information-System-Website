<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DropDownController;

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

Route::get('/', function () {
    return view('login');
});
Route::post('/login', [WebController::class, 'login']);
Route::get('/dashboard/mahasiswa/{nim}', [WebController::class, 'masukMahasiswa']);
Route::get('/dashboard/dosen/{nip}', [WebController::class, 'masukKaryawan']);
Route::get('/dashboard/operator/{nip}', [WebController::class, 'masukKaryawan']);
Route::get('/dashboard/operator/{nip}/manajemen', [WebController::class, 'getMahasiswa']);
Route::get('/dashboard/operator/{nip}/manajemen/addaccount', [WebController::class, 'addAccount']);
Route::get('/dashboard/mahasiswa/{nim}/profile', [WebController::class, 'profile']);
Route::post('/dashboard/mahasiswa/{nim}/profile/edit', [WebController::class, 'edit']);
Route::get('/register', [WebController::class, 'register']);
Route::post('api/fetch-kotakab', [DropDownController::class, 'fatchState']);
Route::post('/register/add', [WebController::class, 'addMahasiswa']);
Route::get('/dashboard/mahasiswa/{nim}/academic', [WebController::class, 'akademik']);
Route::get('/dashboard/dosen/{nip}/validation', [WebController::class, 'validasi']);
Route::get('/dashboard/mahasiswa/{nim}/academic/addIRS', [WebController::class, 'addIRS']);
Route::post('/addAccount', [WebController::class, 'confirmAddAccount']);
Route::get('/dashboard/mahasiswa/{nim}/updateAcc', [WebController::class,'updatePage']);
Route::post('/dashboard/mahasiswa/{nim}/updateAcc/confirm', [WebController::class, 'updateAcc']);
Route::post('/dashboard/mahasiswa/{nim}/academic/addIRS/confirm', [WebController::class, 'confirmAddIRS']);
Route::get('/dashboard/mahasiswa/{nim}/academic/addKHS', [WebController::class, 'addKHS']);
Route::post('/dashboard/mahasiswa/{nim}/academic/addKHS/confirm', [WebController::class, 'confirmAddKHS']);
Route::get('/dashboard/mahasiswa/{nim}/academic/addPKL', [WebController::class, 'addPKL']);
Route::post('/dashboard/mahasiswa/{nim}/academic/addPKL/confirm', [WebController::class, 'confirmAddPKL']);
Route::get('/dashboard/mahasiswa/{nim}/academic/addSkripsi', [WebController::class, 'addSkripsi']);
Route::post('/dashboard/mahasiswa/{nim}/academic/addSkripsi/confirm', [WebController::class, 'confirmAddSkripsi']);
Route::post('/dashboard/dosen/{nip}/validation/{id_khs}', [WebController::class, 'validasiKHS']);