<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ckyc\ckycController;
use App\Http\Controllers\ckyc\CropImageController;
use App\Http\Controllers\ckyc\ServerPingController;
use App\Http\Controllers\ckyc\AppController;

Route::namespace('ckyc')->group(function () {
    Route::get('/',"LoginController@index");
	Route::get('login', "LoginController@index")->name('login');
    Route::post('login', "LoginController@login")->name('login');
    Route::get('logout',"LoginController@logout")->name('logout');
});
Route::middleware('Login')->namespace('ckyc')->group(function () {
Route::get('home',[ckycController::class,'displayHomePage'])->name('home');
Route::get('nview',function(){return view('ckyc.newview');});
Route::post('storeImageToDB',[ckycController::class,'storeImage'])->name('storeImageRoute');
Route::get('getindex',[ckycController::class,'displayIndex'])->name('usermediaRoute');
Route::get('showCifData',[ckycController::class,'showUploadedCIFS'])->name('showUploadedCifs');
Route::get('/download/{id}',[ckycController::class,'downloadFile'])->name('fileDownload');
Route::get('/downloadfile2/{ddate}',[ckycController::class,'downloadFile2'])->name('fileDownload2');
Route::get('/checkcif/{cifno}',[ckycController::class,'getcifno']);
//Route::get('/cimage',[CropImageController::class,'index']);
//Route::post('/upload-image',[CropImageController::class,'uploadCropImage'])->name('croppie.upload-image');
Route::get('image-cropper', [CropImageController::class,'index']);
Route::post('/image-cropper/upload', [CropImageController::class,'upload'])->name('croppie.upload-image');
Route::post('final_submit', [CropImageController::class,'fsubmit'])->name('croppie.upload-image');

Route::get('/show_user_data',[AppController::class,'show_user_data'])->name('show_user_data');
Route::get('/getuserdata',[AppController::class,'getuserdata'])->name('getuserdata');
Route::get('/get_indi_download/{cifnumber}',[AppController::class,'individual_download'])->name('get_indi_download');
Route::get('/download_all/{vals?}',[AppController::class,'download_all'])->name('download_all');

Route::any('emp_summary',[AppController::class,'emp_summary'])->name('emp_summary');

Route::any('testsummary',[AppController::class,'testsummary'])->name('testsummary');






Route::get('/serverping',[ServerPingController::class,'testping'])->name('test_ping');
Route::get('/serverview',[ServerPingController::class,'testpingview'])->name('test_pingview');
Route::get('/sping',[ServerPingController::class,'test_allpings'])->name('test_allpings');
Route::post('searchPingIP/{sip}',[ServerPingController::class,'searchIpPing'])->name('searchIpPingRoute');
Route::view('/ckyctabs','ckyc.ckyc_tabs');
Route::view('/homeall','ckyc.userhomeall');
Route::view('/one','one');
});