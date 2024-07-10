<?php

<<<<<<< HEAD
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WdwController;
=======
use App\Http\Controllers\WwjController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

>>>>>>> 0015bfb2bb49bf44b98d4527abea4ffd161c1eaf
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
////邮件发送验证接口
//Route::post('/send-verification-email', [WdwController::class, 'sendVerificationEmail']);
////学生注册接口
//Route::post('/user/register',[WdwController::class,'WdwStudentRegister']);
////学生登录接口
Route::post('/user/login',[WdwController::class,'WdwStudentLogin']);
//学生删除竞赛之星报名接口
Route::post('/user/deleteCompetitionStar',[WdwController::class,'WdwdeleteCompetition']);
//学生删除科研之星报名接口
Route::post('/user/deleteScienceStar',[WdwController::class,'WdwdeleteScience']);
//学生搜索
Route::post('/user/search', [WdwController::class, 'search']);
//管理员查询竞赛之星接口
Route::post('/admin/search_competitionStar', [WdwController::class, 'competition_star_registrations_search']);
//管理员查询双创之星接口
Route::post('/admin/search_innovationStar', [WdwController::class, 'innovation_star_registrations_search']);
//管理员查询双创之星接口
Route::post('/admin/search_scienceStar', [WdwController::class, 'science_star_registrations_search']);
//学生新增科研之星申报信息接口
Route::post('/user/addScienceStar', [WdwController::class, 'apply_science_star']);
//学生审批科研之星申报信息接口
Route::post('admin/approveScienceStar', [WdwController::class, 'approval1']);
//管理员审批竞赛之星申报信息接口
Route::post('/admin/approveCompetitionStar', [WdwController::class, 'approval']);
//学生新增科研之星申报信息接口
Route::post('/user/addCompetitionStar', [WdwController::class, 'apply_competition_star']);
//Route::post('/user/logout',[WdwController::class,'logoutUser']);

Route::middleware('jwt.role:students')->prefix('students')->group(function (){
    Route::post('logout', [WdwController::class, 'logoutStudent']);//学生登出
});
=======


    Route::post('user/register', [WwjController::class, 'Wwjregister']);
    Route::post('user/sendVerificationCode', [WwjController::class, 'sendVerificationCode'])->name('send.verification.code');
    Route::post('user/forgotPassword', [WwjController::class, 'forgotPassword']);
    Route::get('admin/export-competition-star', [WwjController::class, 'exportCompetitionStar']);
    Route::get('admin/export-innovation-star', [WwjController::class, 'exportInnovationStar']);
    Route::get('admin/export-science-star', [WwjController::class, 'exportScienceStar']);
    Route::post('user/viewScienceStar', [WwjController::class, 'viewScienceStar']);
//    Route::post('certificateContent', [WwjController::class, 'certificateContent']);





>>>>>>> 0015bfb2bb49bf44b98d4527abea4ffd161c1eaf
