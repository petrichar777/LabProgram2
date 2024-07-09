<?php

use App\Http\Controllers\WwjController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


    Route::post('user/register', [WwjController::class, 'Wwjregister']);
    Route::post('user/sendVerificationCode', [WwjController::class, 'sendVerificationCode'])->name('send.verification.code');
    Route::post('user/forgotPassword', [WwjController::class, 'forgotPassword']);
    Route::get('admin/export-competition-star', [WwjController::class, 'exportCompetitionStar']);
    Route::get('admin/export-innovation-star', [WwjController::class, 'exportInnovationStar']);
    Route::get('admin/export-science-star', [WwjController::class, 'exportScienceStar']);
    Route::post('user/viewScienceStar', [WwjController::class, 'viewScienceStar']);
//    Route::post('certificateContent', [WwjController::class, 'certificateContent']);





