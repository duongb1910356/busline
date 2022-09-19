<?php

use Illuminate\Support\Facades\Route;
use App\Models\Tuyen;
use App\Models\TinTuc;


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

Route::get('/login', function () { return view('login.login');})->name('login');
Route::post('/login', 'App\Http\Controllers\LoginController@login');
Route::get('/logout', 'App\Http\Controllers\LoginController@logout');

// Route::get('/', function(){ return redirect('login');});

Route::get('/', 'App\Http\Controllers\TinTucController@showTrangchu')->name('home');

Route::get('/tintuc/{id}', 'App\Http\Controllers\TinTucController@showTinTucChiTiet');
Route::get('/datve', 'App\Http\Controllers\TinTucController@showKhachDatVe');
Route::get('/datve/timlich', 'App\Http\Controllers\TinTucController@timLichTrinh');
Route::get('/laysochotrong', 'App\Http\Controllers\VeController@getSoGheTrong');


Route::post('/thanhtoan', 'App\Http\Controllers\PayMentController@showPayMent');
Route::get('/congratulations', 'App\Http\Controllers\PayMentController@showcongratulations');
Route::get('/tracuuhoadon', 'App\Http\Controllers\ChucNangKhachController@traCuuHoaDon');
Route::get('/ketquatracuuve/{idve}', 'App\Http\Controllers\ChucNangKhachController@showKetQuaTraCuuVe');


Route::get('/datve/khach', 'App\Http\Controllers\PayMentController@datVeXe');
Route::get('/datve/getlistcho', 'App\Http\Controllers\TinTucController@getListCho');
Route::get('/tinnhan', 'App\Http\Controllers\PayMentController@sendSMS');

Route::post('/huyve/{id}', 'App\Http\Controllers\ChucNangKhachController@huyVe');






// Route::get('/trangchu', 'App\Http\Controllers\VeController@showTrangchu')->name('home');


Route::get('/ve/banve', 'App\Http\Controllers\VeController@showBanVe');
Route::get('/ve/banve/lichtrinh', 'App\Http\Controllers\VeController@findLichTrinh');
Route::get('/abc', 'App\Http\Controllers\TestController@test');
Route::get('/ve/banve/lichtrinh/{id}', 'App\Http\Controllers\VeController@getInfoLichTrinh');
Route::get('/ve/doicho/{id}', 'App\Http\Controllers\VeController@getInfoLichTrinh');
Route::get('/ve/capnhat/doicho', 'App\Http\Controllers\VeController@capNhatVe');

Route::get('/ve/quanlyve/timlich', 'App\Http\Controllers\VeController@timLich');

Route::get('/ve/lichtrinh/danhsachve', 'App\Http\Controllers\VeController@findListVe');
Route::get('/ve/capnhat', 'App\Http\Controllers\VeController@suaVe');


Route::get('/ve/banve/datve', 'App\Http\Controllers\VeController@datVeXe');
Route::get('/ve/inve/{id}', 'App\Http\Controllers\VeController@inVeXe');
Route::get('/ve/quanlyve', 'App\Http\Controllers\VeController@showListVe');
Route::get('/xoave/{id}', 'App\Http\Controllers\VeController@deleteVe');

Route::get('/lichtrinh/quanly', 'App\Http\Controllers\LichTrinhController@showLichTrinh');
Route::get('/lichtrinh/xoa', 'App\Http\Controllers\LichTrinhController@xoaLichTrinh');

Route::get('/lichtrinh/benxetheotuyen', 'App\Http\Controllers\LichTrinhController@getBenXeTheoTuyen');

Route::get('/tuyen/quanly', 'App\Http\Controllers\TuyenController@showDanhSachTuyen');

Route::get('/tuyen/xoa/{idtuyen}', 'App\Http\Controllers\TuyenController@xoaTuyen');
Route::get('/tuyen/sua/{idtuyen}', 'App\Http\Controllers\TuyenController@suaTuyen');
Route::get('/tuyenbenxe/{idtuyen}', 'App\Http\Controllers\TuyenController@getBenXeOfTuyen');


use App\Http\Controllers\PDFController;
 
Route::get('create-pdf-file', [PDFController::class, 'index']);
