<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller;
use App\Models\science_star_registrations;
use App\Models\students;
use App\Mail\VerificationCode;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Exports\CompetitionStarExport;
use App\Exports\InnovationStarExport;
use App\Exports\ScienceStarExport;
use Maatwebsite\Excel\Facades\Excel;

class WwjController extends Controller
{

    //邮箱发送接口
    public function sendVerificationCode(Request $request)
    {
        //使用 Laravel 的验证器 Validator 来检查用户提供的邮箱地址是否符合规定格式（必须存在且为有效的邮箱格式）
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        //失败处理
        if ($validator->fails()) {
            return json_fail(['status' => 'fail', 'message' => '邮箱格式不正确', 'code' => 400]);
        }
        //随机数生成，从中随机选取六个数字
        $code = rand(100000, 999999); // 生成随机验证码
        $encodedCode = base64_encode($code); // 加密验证码
        Session::put('verification_code', $encodedCode); // 在会话层存储加密后的验证码
        Session::put('email', $request->email);  //在会话层存储用户邮箱

        try {
            Mail::to($request->email)->send(new VerificationCode($code)); // 发送未加密的验证码
            return json_success(['status' => 'success', 'message' => '验证码已发送', 'code' => 200]);//判断
        } catch (\Exception $e) {
            return json_fail(['status' => 'fail', 'message' => '邮件发送失败: ' . $e->getMessage(), 'code' => 500]);
        }
    }


    public function Wwjregister(Request $request)
    {
        $sessionCode = Session::get('verification_code'); //在会话层获取验证码
        $sessionEmail = Session::get('email');
        $decodedSessionCode = base64_decode($sessionCode);  //将验证码解密
        //判断验证码是否匹配
        if ($request->verification_code != $decodedSessionCode || $request->email != $sessionEmail) {
            return json_fail(['status' => 'fail', 'message' => '验证码错误或邮箱不匹配', 'code' => 400]);
        }

        $registeredInfo = [
            'account' => $request->account,
            'grade' => $request->grade,
            'major' => $request->major,
            'class' => $request->class,
            'name' => $request->name,
            'password' => Hash::make($request->password), //对密码进行哈希加密
            'email' => $request->email,
        ];
        //查询账号，进行判断
        $count = students::where('account', $request->account)->count();

        if ($count > 0) {
            return json_fail(['status' => 'fail', 'message' => '该用户信息已经被注册过了', 'code' => 101]);
        }

        try {
            //在数据库中插入相应信息
            $student = students::create($registeredInfo);
            return json_success(['status' => 'success', 'message' => '注册成功!', 'data' => $student->id, 'code' => 200]);
        } catch (\Exception $e) {
            return json_fail(['status' => 'fail', 'message' => '注册失败: ' . $e->getMessage(), 'code' => 100]);
        }
    }


    public function forgotPassword(Request $request)
    {
        // 获取新密码
        $new_password = $request->password;

        // 查找学生
        $student = students::where('account', $request->account);

        if (!$student) {
            return json_fail(['status' => 'fail', 'message' => '该学生未注册', 'code' => 404]);
        }

        // 验证验证码
        $sessionCode = Session::get('verification_code');
        $sessionEmail = Session::get('email');
        $decodedSessionCode = base64_decode($sessionCode);

        if ($request->verification_code != $decodedSessionCode || $request->email != $sessionEmail) {
            return json_fail(['status' => 'fail', 'message' => '验证码错误或邮箱不匹配', 'code' => 400]);
        }

        try {
            // 更新密码
            students::where('account', $request->account)->where('email', $request->email)->update(['password' => Hash::make($new_password)]);
            return json_success(['status' => 'success', 'message' => '密码重置成功', 'code' => 200]);
        } catch (\Exception $e) {
            return json_fail(['status' => 'fail', 'message' => '密码重置失败: ' . $e->getMessage(), 'code' => 500]);
        }
    }

    //导出竞赛之星
    public function exportCompetitionStar()
    {
        return Excel::download(new CompetitionStarExport, '竞赛之星.xlsx');
    }

    //导出双创之星
    public function exportInnovationStar()
    {
        return Excel::download(new InnovationStarExport, '双创之星.xlsx');
    }

    //导出科技之星
    public function exportScienceStar()
    {
        return Excel::download(new ScienceStarExport, '科研之星.xlsx');
    }

    //学生查看科技之星
    public function viewScienceStar(Request $request)
    {
        try {
            // 获取当前登录的学生ID
            $id = $request['student_id'];

            // 根据学号或姓名查询学生报名信息
            $scienceStarRegistrations = science_star_registrations::where('student_id', $id)
                ->get([
                        'grade',
                        'major',
                        'class',
                        'name',
                        'project_category',
                        'project_name',
                        'approval_time',
                        'status',
                        'certificate',
                        'rejection_reason'
                    ]
                );

            // 检查是否有报名信息
            if ($scienceStarRegistrations->isEmpty()) {
                return response()->json(['message' => '没有找到您的科研之星报名信息'], 404);
            }
            // 返回报名信息
            return response()->json(['data' => $scienceStarRegistrations], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => '查看报名信息时发生错误', 'error' => $e->getMessage()], 500);
        }
    }
