<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller;
use App\Models\competition_star_registrations;
use App\Models\science_star_registrations;
use App\Models\innovation_star_registrations;
use App\Models\students;
use Illuminate\Http\Request;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;

class WdwController extends Controller
{
    //学生登录接口
    public function WdwStudentLogin(Request $request)
    {
        $user['account'] = $request['account'];
        $user['password']= $request['password'];
        $token = auth('students')->attempt($user);
        return $token?
            json_success('登录成功!',$token, 200):
            json_fail('登录失败!账号或密码错误',null, 100 ) ;
    }

    //学生用户登出
    public function logoutStudent(){
        auth('students')->logout();
        return json_success("用户退出登录成功",null,200);
    }


    //学生删除竞赛之星的报名信息
    public function WdwdeleteCompetition(Request $request)
    {
        $id = $request['id'];
        // 查找学生的报名信息
        $student = students::find($id);
        //return $student;
        $data = $student->guestinfo1;
        //return $data
        // 判断查找是否成功
        if ($data) {
            // 删除报名信息
            $data->delete();
            return json_success('删除成功！',null,200);
        } else {

            return json_fail('删除失败，未找到该信息！',null,100);
        }
    }

    //学生删除科研之星的报名信息
    public function WdwdeleteScience(Request $request)
    {
        $id = $request['id'];
        // 查找学生的报名信息
        $student = students::find($id);
        //return $student;
        $data = $student->guestinfo2;
        // 判断查找是否成功
        if ($data) {
            // 删除报名信息
            $data->delete();
            return json_success('删除成功！',null,200);
        } else {
            return json_fail('删除失败，未找到该信息！',null,100);
        }
    }

    //学生搜索
    public function search(Request $request)
    {
        // 创建查询构造器，用于构建数据库查询语句
        $query = students::searchStudents([
            'name' => $request->input('name'),
            'major' => $request->input('major'),
            'grade' => $request->input('grade')
        ]);

        // 标记是否有任何过滤条件
        $hasFilters = $request->filled('name') || $request->filled('major') || $request->filled('grade') ||
            $request->filled('competition_name') || $request->filled('project_category') || $request->filled('company_name');

        // 如果没有任何过滤条件，不返回任何报名信息
        if (!$hasFilters) {
            return json_fail('搜索失败', null, 100);
        }

        // 定义一个数组来存储所有符合条件的报名信息
        $registrations = [];

        // 获取符合条件的学生记录
        $students = $query->get();

        foreach ($students as $student) {
            // 获取符合条件的 competition_star_registrations
            if ($request->filled('competition_name')) {
                $competitionRegistrations = competition_star_registrations::searchByCompetitionName(
                    $request->input('competition_name'),
                    $student->id
                );
                $registrations = array_merge($registrations, $competitionRegistrations);

            }

            // 获取符合条件的 science_star_registrations
            if ($request->filled('project_category')) {
                $scienceRegistrations = science_star_registrations::searchByProjectCategory(
                    $request->input('project_category'),
                    $student->id
                );
                $registrations = array_merge($registrations, $scienceRegistrations);
            }

            // 获取符合条件的 innovation_star_registrations
            if ($request->filled('company_name')) {
                $innovationRegistrations = innovation_star_registrations::searchByCompanyName(
                    $request->input('company_name'),
                    $student->id
                );
                $registrations = array_merge($registrations, $innovationRegistrations);
            }
        }

        return json_success('搜索成功', $registrations, 200);
    }


    //管理员搜索竞赛之星信息
    public function competition_star_registrations_search(Request $request)
    {
        // 获取过滤条件
        $filters = [
            'name' => $request->input('name'),
            'major' => $request->input('major'),
            'grade' => $request->input('grade'),
            'competition_name' => $request->input('competition_name'),
            'status' => $request->input('status'),
        ];

        // 检查是否有任何过滤条件
        $hasFilters = array_filter($filters);

        // 如果没有任何过滤条件，返回空结果
        if (empty($hasFilters)) {
            return json_fail('搜索失败',null,100);
        }

        // 使用模型中的方法进行查询
        $registrations = competition_star_registrations::searchByFilters($filters);

        // 返回查询结果
        return json_success('搜索成功',$registrations,200);
    }

    //管理员搜索双创之星信息
    public function innovation_star_registrations_search(Request $request)
    {
        // 获取过滤条件
        $filters = [
            'name' => $request->input('name'),
            'major' => $request->input('major'),
            'grade' => $request->input('grade'),
            'company_name' => $request->input('company_name'),
            'status' => $request->input('status'),
            'entity_type' => $request->input('entity_type'),
            'company_scale' => $request->input('company_scale'),
        ];

        // 检查是否有任何过滤条件
        $hasFilters = array_filter($filters);

        // 如果没有任何过滤条件，返回空结果
        if (empty($hasFilters)) {
            return json_fail('搜索失败',null,100);
        }

        // 使用模型中的方法进行查询
        $registrations = innovation_star_registrations::searchByFilters($filters);

        // 返回查询结果
        return json_success('搜索成功',$registrations,200);
    }

    //管理员搜索科研之星
    public function science_star_registrations_search(Request $request)
    {
        // 获取过滤条件
        $filters = [
            'name' => $request->input('name'),
            'major' => $request->input('major'),
            'project_category' => $request->input('project_category'),
            'status' => $request->input('status'),
            'project_name' => $request->input('project_name'),
            'approval_time' => $request->input('approval_time')
        ];
        //dd(1);
        // 检查是否有任何过滤条件
        $hasFilters = array_filter($filters);

        // 如果没有任何过滤条件，返回空结果
        if (empty($hasFilters)) {
            return json_fail('搜索失败',null,100);
        }


        // 查询并返回结果
        $registrations = science_star_registrations::searchByFilters($filters);

        return json_success('搜索成功',$registrations,200);
    }

        //学生新增科研之星申报信息
    public function apply_science_star(Request $request){
        $user['grade'] = $request['grade'];
        $user['major'] = $request['major'];
        $user['class'] = $request['class'];
        $user['name'] = $request['name'];
        $user['project_category'] = $request['project_category'];
        $user['project_name'] = $request['project_name'];

        //检查是否重复报名
        $count = science_star_registrations::Numberofproject($user);
        if($count != 0){
            return json_fail('不能重复报名项目',null,100);
        }

        //查找学生的student_id
        $student = students::findstudent_id($user);

        if(is_error($student) == true){
            json_fail('无法查找用户student_id',null,100);
        }

        $user['student_id'] = $student->id;

        //将报名信息插入到数据库中
        $p = science_star_registrations::increase($user);
        //dd(1);
        if(is_error($p) == true)
        {
            return json_fail('报名失败',null,100);
        }else{
            return json_success('报名成功',null,200);
        }
    }


    //管理员审批科研之星
    public function approval1(Request $request)
    {
        $data['grade'] = $request['grade'];
        $data['major'] = $request['major'];
        $data['class'] = $request['class'];
        $data['name'] = $request['name'];
        $data['status'] = $request['status'];
        $data['project_name'] = $request['project_name'];
        $data['rejection_reason'] = $request['rejection_reason'];
        $data['certificate'] = $request['certificate'];

        // return $data;
        $student = students::findstudent_id($data);
        //return $student;
        if(is_error($student) == true){
            json_fail('无法查找用户student_id',null,100);
        }
        //return $student;
        $data['student_id'] = $student->id;
        //$createtime = science_star_registrations::FindCreatedtime($data)->approval_time;
        $createtime = (string)(science_star_registrations::FindCreatedtime($data)->approval_time);
        //return $createtime;

        $update_time = (string)now();
        //return $update_time;

        $data['time'] = $createtime . '/' . $update_time;

        if($data['status'] == -1){
            //前端做传入进来的理由就不允许为空
            $p = science_star_registrations::editRejection_reason($data);
            if(is_error($p) == true){
                return json_fail('驳回理由添加失败',null,100);
            }
            return json_success('审批未通过',null,200);
        }
        if($data['status'] == 1){
            $p = science_star_registrations::editCertificate($data);
            //return $p;
            if(is_error($p) == true){
                return json_fail('数据修改失败',null,100);
            }
            return json_success('审批通过',null,100);
        }
    }

    public function apply_competition_star(Request $request){
        $user['grade'] = $request['grade'];
        $user['major'] = $request['major'];
        $user['class'] = $request['class'];
        $user['name'] = $request['name'];
        $user['competition_name'] = $request['competition_name'];

        //检查是否重复报名
        $count = competition_star_registrations::Numberofproject($user);
        if($count != 0){
            return json_fail('不能重复报名项目',null,100);
        }

        $user['time'] = now();

        //查找学生的student_id
        $student = students::findstudent_id($user);

        if(is_error($student) == true){
            json_fail('无法查找用户student_id',null,100);
        }

        $user['student_id'] = $student->id;

        //将报名信息插入到数据库中
        $p = competition_star_registrations::increase($user);
        //dd(1);
        if(is_error($p) == true)
        {
            return json_fail('报名失败',null,100);
        }else{
            return json_success('报名成功',null,200);
        }
    }


  }

