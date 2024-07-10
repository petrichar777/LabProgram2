<?php

<<<<<<< HEAD
use App\Http\Controllers\YyhController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LywController;
=======
use App\Http\Controllers\WwjController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

>>>>>>> f96da5e945cc34c0ee9f5ea316ca832f5d45270a
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

<<<<<<< HEAD
Route::post('/user/addCompetitionStar',[App\Http\Controllers\LywController::class,'NewAdd']);
Route::post('/admin/approveCompetitionStar',[App\Http\Controllers\LywController::class,'approval']);
Route::post('/admin/competitionStar',[App\Http\Controllers\LywController::class,'getAllCompetitionStars']);
Route::post('/user/viewCompetitionStar',[App\Http\Controllers\LywController::class,'competitionStar']);
=======

    Route::post('user/register', [WwjController::class, 'Wwjregister']);
    Route::post('user/sendVerificationCode', [WwjController::class, 'sendVerificationCode'])->name('send.verification.code');
    Route::post('user/forgotPassword', [WwjController::class, 'forgotPassword']);
    Route::get('admin/export-competition-star', [WwjController::class, 'exportCompetitionStar']);
    Route::get('admin/export-innovation-star', [WwjController::class, 'exportInnovationStar']);
    Route::get('admin/export-science-star', [WwjController::class, 'exportScienceStar']);
    Route::post('user/viewScienceStar', [WwjController::class, 'viewScienceStar']);
//    Route::post('certificateContent', [WwjController::class, 'certificateContent']);
>>>>>>> f96da5e945cc34c0ee9f5ea316ca832f5d45270a





