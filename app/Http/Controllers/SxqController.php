<?php

namespace App\Http\Controllers;

use App\Models\innovationstarregistrations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;
use App\Models\students;



class SxqController extends Controller
{
    public function innovationStar(Request $request)
    {
        try {
            // 查询所有双创之星申报信息
            $registrations = innovationstarregistrations::all([
                'grade',
                'major',
                'class',
                'name',
                'company_name',
                'entity_type',
                'registration_time',
                'company_scale',
                'status',
                'certificate',
                'rejection_reason'
            ]);

            // 检查是否有报名信息
            if ($registrations->isEmpty()) {
                return response()->json(['message' => '没有找到双创之星报名信息'], 404);
            }

            // 返回报名信息
            return response()->json(['data' => $registrations], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => '查看报名信息时发生错误', 'error' => $e->getMessage()], 500);
        }
    }

    public function approveInnovationStar(Request $request)
    {
        $data['grade'] = $request['grade'];
        $data['major'] = $request['major'];
        $data['class'] = $request['class'];
        $data['name'] = $request['name'];
        $data['status'] = $request['status'];
        $data['company_name'] = $request['company_name'];
        $data['rejection_reason'] = $request['rejection_reason'];
        $data['certificate'] = $request['certificate'];

        //return $data;
        $student = students::findstudent_id($data);
        //return $student;
        if (is_error($student) == true) {
            json_fail('无法查找用户student_id', null, 100);
        }
        //return $student;
        $data['student_id'] = $student->id;
        //return  $data['student_id'];
        //return $data['time'];
        //return $data['student_id'];
        if ($data['status'] == -1) {
            //前端做传入进来的理由就不允许为空
            $p = innovationstarregistrations::editRejection_reason($data);
            //return $p;
            if (is_error($p) == true) {
                return json_fail('驳回理由添加失败', null, 100);
            }
            return json_success('审批未通过', null, 200);
        }
        if ($data['status'] == 1) {
            $p = innovationstarregistrations::editCertificate($data);
            if (is_error($p) == true) {
                return json_fail('数据修改失败', null, 100);
            }
            return json_success('审批通过', null, 100);
        }
    }


    public function useraddInnovationStar(Request $request)
    {
        $data ['major'] = $request['major'];
        $data ['grade'] = $request['grade'];
        $data ['name'] = $request['name'];
        $data ['class'] = $request['class'];
        $data['entity_type'] =$request['entity_type'];//实体，虚体
        $data['company_name']= $request['company_name'];
        $data['registration_time']=now();
        $data['certificate']= $request['certificate'];
        $data['student_id']=$request['student_id'];
        $dd=innovationstarregistrations::addlnnovationStar($data);//后面在添加一个函数，然后用与student_id
        if($dd) {
            return json_success('添加成功！', $data, 200);
        }else{
        return json_fail('添加失败！', $data, 500);
        }
    }
    }

