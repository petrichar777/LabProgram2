<?php

use App\Http\Controllers\YyhController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LywController;
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

Route::post('/user/addCompetitionStar',[App\Http\Controllers\LywController::class,'NewAdd']);
Route::post('/admin/approveCompetitionStar',[App\Http\Controllers\LywController::class,'approval']);
Route::post('/admin/competitionStar',[App\Http\Controllers\LywController::class,'getAllCompetitionStars']);
Route::post('/user/viewCompetitionStar',[App\Http\Controllers\LywController::class,'competitionStar']);





