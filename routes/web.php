<?php

use App\Http\Controllers\ApprovalRequestController;
use App\Http\Controllers\BarangkeluarController;
use App\Http\Controllers\BarangmasterController;
use App\Http\Controllers\BarangmasukController;
use App\Http\Controllers\StokopnameController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProductionrequestController;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');

    Route::post('/login', [AuthController::class, 'login']);
});
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/register', function () {
    return view('register');
});

Route::middleware('auth')->group(function () {
    Route::get('/',[DashboardController::class,'index'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/add-user', [UserController::class, 'add']);
    Route::post('/add-user', [UserController::class, 'store']);
    Route::delete('/delete/user/{id}',[UserController::class,'delete']);
    Route::get('/update/user/{id}',[UserController::class,'update']);
    Route::patch('/update/user/{id}',[UserController::class,'edit']);

    
    Route::get('/barang-masuk', [BarangmasukController::class, 'index']);
    Route::get('/input-barang-masuk', [BarangmasukController::class, 'input']);
    Route::get('/barang-masuk/{id}', [BarangmasukController::class, 'getBarang']);
    Route::post('/input-barang-masuk', [BarangmasukController::class, 'store']);
    Route::get('/delete/barang-masuk/{id}', [BarangmasukController::class, 'getBarangForDelete']);
    Route::get('/update/barang-masuk/{id}', [BarangmasukController::class, 'update']);
    Route::put('/update/barang-masuk/{id}', [BarangmasukController::class, 'updateStore']);
    Route::get('/details/barang-masuk/{id}', [BarangmasukController::class, 'details']);
    Route::get('/cetak/barang-masuk',[BarangmasukController::class,'cetak'])->name('cetak.barang-masuk');
    Route::get('/cetak/barang-masuk/filter',[BarangmasukController::class,'filterbarangmasuk'])->name('filter.barang-masuk');
    Route::get('/cetak/barang-masuk/pdf',[PdfController::class,'barang_masuk'])->name('print.barang-masuk');



    Route::get('/barang-keluar', [BarangkeluarController::class, 'index']);
    Route::get('/input/barang-keluar',[BarangkeluarController::class,'input']);
    Route::post('/input/barang-keluar',[BarangkeluarController::class,'store']);
    Route::get('/barang-keluar/{id}',[BarangkeluarController::class,'detail']);
    Route::get('/delete/barang-keluar/{id}',[BarangkeluarController::class,'getBarangForDelete']);
    Route::get('/cetak/barang-keluar',[BarangkeluarController::class,'cetak'])->name('cetak.barang-keluar');
    Route::get('/cetak/barang-keluar/filter',[BarangkeluarController::class,'filterBarangKeluar'])->name('filter.barang-keluar');
    Route::get('/cetak/barang-keluar/pdf',[PdfController::class,'barang_keluar'])->name('print.barang-keluar');

    Route::get('/barang-master', [BarangmasterController::class, 'index']);
    Route::post('/barang-master', [BarangmasterController::class, 'store']);
    Route::get('/input-barang-master', [BarangmasterController::class, 'input']);
    Route::get('/update/barang-master/{id}',[BarangmasterController::class,'update']);
    Route::put('/update/barang-master/{id}',[BarangmasterController::class,'edit']);
    Route::delete('/delete/barang-master/{id}',[BarangmasterController::class,'destroy']);
    Route::get('/barang-master/{id}',[BarangmasterController::class,'detail']);
    Route::get('/cetak/barang-master',[BarangmasterController::class,'cetak']);
    Route::get('/print/barang-master',[PdfController::class,'barang_master'])->name('print.barang-master');



    Route::get('/approval-request',[ApprovalRequestController::class,'index']);
    Route::get('/update/approval/{modul}/{aksi}/{id}/{idrequest}',[ApprovalRequestController::class,'getModul']);
    Route::post('/update/approval/{id}/{aksi}',[ApprovalRequestController::class,'updateStatus']);
    Route::patch('/update/approval/barang-keluar/{id}/{aksi}',[ApprovalRequestController::class,'updateStatusBarangout']);
    Route::patch('/delete/approval/barang-keluar/{idrequest}/{aksi}/{kode}',[ApprovalRequestController::class,'deleteBarangKeluar']);
    Route::patch('/update/approval/stok-opname/{id}/{aksi}',[ApprovalRequestController::class,'updateStatusStokOpname']);
    Route::patch('/delete/approval/stok-opname/{id}/{aksi}',[ApprovalRequestController::class,'deleteStokOpname']);



    Route::get('/stok-opname', [StokopnameController::class, 'index']);
    Route::get('/input/stok-opname',[StokopnameController::class,'input']);
    Route::post('/input/stok-opname',[StokopnameController::class,'store']);
    Route::get('/detail/stok-opname/{id}',[StokopnameController::class,'detail']);
    Route::post('/delete/stok-opname/{id}',[StokopnameController::class,'delete']);
    Route::get('/cetak/stok-opname/',[StokopnameController::class,'cetak'])->name('cetak.stok-opname');
    Route::get('/cetak/stok-opname/filter',[StokopnameController::class,'filter'])->name('filter.stok-opname');
    Route::get('/cetak/stok-opname/pdf',[PdfController::class,'stok_opname'])->name('print.stok-opname');

    Route::get('/production-request',[ProductionrequestController::class,'index'])->name('production-request.index');
    Route::get('/input/production-request',[ProductionrequestController::class,'input']);
    Route::post('/input/production-request',[ProductionrequestController::class,'store']);
    Route::delete('/delete/production-request/{id}',[ProductionrequestController::class,'delete'])->name('delete.production-request');
    Route::get('/detail/production-request/{id}',[ProductionrequestController::class,'detail'])->name('detail.production-request');
    
    Route::get('/change-password',[UserController::class,'changePassword'])->name('change-password');
    Route::post('/change-password',[UserController::class,'storePassword'])->name('change-password');
});
