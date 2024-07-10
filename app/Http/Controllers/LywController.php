<?php

namespace App\Http\Controllers;
use App\Http\Model\competition_star_registrations;
use App\Http\Model\students;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;
class LywController extends Controller
{
    public static function NewAdd(Request $request)
    {
        $userdata = [
            'grade' => $request['grade'],
            'major' => $request['major'],
            'class' => $request['class'],
            'name' => $request['name'],
            'competition_name' => $request['competition_name'],
            'registration_time' => Carbon::now(),
            'status' => 0,
        ];

        // 找到学生
        $student = students::Finding($userdata);
        if (!$student) {
            return json_fail('学生未找到', null, 101);
        }

        $userdata['student_id'] = $student->id;

        // 调用 AddStudent 方法添加学生
        $result = competition_star_registrations::AddStudent($userdata);

        // 检查返回结果并返回适当的响应
        if ($result['status'] === 'fail') {
            return json_fail('添加失败', $result, 100);
        } elseif ($result['status'] === 'error') {
            return json_fail('添加失败', $result, 100);
        } else {
            return json_success('添加成功', $result, 200);
        }
    }

    // 无信息


    public function approval(Request $request)//老师审批
    {
        $data['grade'] = $request['grade'];
        $data['major'] = $request['major'];
        $data['class'] = $request['class'];
        $data['name'] = $request['name'];
        $data['status'] = $request['status'];
        $data['competition_name'] = $request['competition_name'];
        $data['rejection_reason'] = $request['rejection_reason'];
        $data['certificate'] = $request['certificate'];

        // return $data;
        $student = students::Finding($data);
        //return $student;
        if (is_error($student)) {
            json_fail('无法查找用户student_id', null, 100);
        }
        //return $student;
        $data['student_id'] = $student->id;

        //return $data['student_id'];

        //return $data['time'];
        //return $data['student_id'];
        if ($data['status'] == -1) {
            //前端做传入进来的理由就不允许为空
            $p = competition_star_registrations::editRejection_reason($data);
            //return $p;
            if (is_error($p) == true) {
                return json_fail('驳回理由添加失败', null, 100);
            }
            return json_success('审批未通过', null, 200);
        }
        if ($data['status'] == 1) {
            $p = competition_star_registrations::editCertificate($data);
            //return $p;
            if (is_error($p) == true) {
                return json_fail('数据修改失败', null, 100);
            }
            return json_success('审批通过', null, 100);
        }
    }

    public static function getAllCompetitionStars() // 老师查看全部数据
    {
        try {
            $allData = competition_star_registrations::getAllData();

            if ($allData->isEmpty()) {
                // 无数据
                return json_fail('没有找到任何竞赛之星的数据', null, 100);
            } else {
                // 返回全部数据
                return json_success('查询成功', $allData, 200);
            }
        } catch (\Exception $e) {
            return json_fail('查询失败，错误: ' . $e->getMessage(), null, 100);
        }
    }
    public static function competitionStar(Request $request)//学生查询
    {
        $id = $request['student_id'];
        //return $id;
        $res = competition_star_registrations::FindDate($id);
        //return (is_null($res));
        if (!$res->isEmpty()) {
            // 查询成功
            return json_success(
                '查询成功',
                $res,
                200
            );
        } else {
            // 无信息
            return json_fail(
                '查询失败', null, 100
            );

        }
    }


}


