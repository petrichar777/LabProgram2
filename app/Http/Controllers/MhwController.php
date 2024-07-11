<?php
namespace App\Http\Controllers;
use App\Models\innovation_star_registrations;
use   Illuminate\Routing\Controller as Controller;
use Illuminate\Http\Request;
use App\Models\science_star_registrations;
use App\Models\administrators;
use Carbon\Carbon;
use App\Models\competition_star_registrations;
use App\Models\students;

class MhwController extends Controller
{
    public function editScienceStar(Request $request)
    {
        $data ['major'] = $request['major'];
        $data['grade'] = $request['grade'];//Grade,Project_category 项目类别,Project_name 项目名称/软著名称
        $data ['name'] = $request['name'];
        $data['class'] = $request['class'];
        $data['project_category'] = $request['project_category'];//
        $data['project_name'] = $request['project_name'];
        $data['approval_time'] = now();//修改的当时时间
        $data['created_at']=now();
        $data['updated_at']=now();
        $data['certificate '] = $request['certificate'];//后续修改，证书修改链接
        $data['student_id'] = $request['student_id'];
        $dd = science_star_registrations::xiugai($data);

        if ($dd) {
            return json_success('修改成功！', $data, 200);
        } else {
            return json_fail('修改失败！', $data, 100);
        }
    }

    //管理员注册
    public  function zhuceadmin(Request $request)
    {
        $data['account'] =$request['account'];
        $data['password'] =bcrypt($request['password']);
        $account = $data['account'];
        $data['created_at']=now();
        $data['updated_at']=now();
        $count =administrators::shuliang($account);
        if ($count == 0){
            $zhu =administrators::zhuce($data);
            var_dump($zhu);
            if ($zhu){
                var_dump('账号注册成功！');
            }else{
                return json_fail('注册失败!检测是否存在的时候出错啦', $count, 100);
            }
        }else{
            var_dump('已存在该学号的账号！');
        }
    }
        // 从请求中获取账号和密码

    //管理员登录
        public function adminlogin(Request $request)
        {
            $user['account'] = $request['account'];//账号
            $user['password'] = $request['password'];//密码
           // $user['created_at']=now();
           // $user['updated_at']=now();
            $token = auth('administrators')->attempt($user);
            return $token?
                json_success('登录成功!',$token,  200):
               json_fail('登录失败!账号或密码错误!!',null, 100 ) ;
        }
    public function adminlogout(){//登出操作
        auth('administrators')->logout();
        return json_success("管理者退出登录成功！",null,200);
    }


    public function usereditCompetitionStar(Request $request)
    {
        $data ['major'] = $request['major'];
        $data['grade'] = $request['grade'];//Grade,Project_category 项目类别,Project_name 项目名称/软著名称
        $data ['name'] = $request['name'];
        $data['class'] = $request['class'];
        $data['project_category'] =$request['project_category'];//
        $data['project_name']= $request['project_name'];
        $data['approval_time']=Carbon::now();//修改的当时时间
        $data['created_at']=now();
        $data['updated_at']=now();
        $data['certificate ']= $request['certificate'];//后续修改，证书修改链接
        $dd=competition_star_registrations::xiugai1($data);
        if($dd){
            return json_success('修改成功！',$data,200  );
        }else{
            return json_fail('修改失败！',$data,100  );
        }
    }
    public function useraddInnovationStar(Request $request)//学生增加
    {
        $data ['major'] = $request['major'];
        $data['grade'] = $request['grade'];//Grade,Project_category 项目类别,Project_name 项目名称/软著名称
        $data ['name'] = $request['name'];
        $data['class'] = $request['class'];
        $data['entity_type'] =$request['entity_type'];//实体，虚体
        $data['company_name']= $request['company_name'];//公司名字
        $data['registration_time']=now();//公司注册时间
        $data['created_at']=now();
        $data['updated_at']=now();
        $data['certificate']= $request['certificate'];//后续修改，证书修改链接
        $student=students::charu($data);
        //return $student;
        $data['student_id']=$student->id;
        $tt=innovation_star_registrations::shuliang($data);//报名的唯一学号限制
        if($tt==0){
            $dd=innovation_star_registrations::zengtian($data); //后面在添加一个函数，然后用与student_id
           if($dd){
            return json_success('添加成功！',$data,200  );
        }else{
            return json_fail('添加失败！',$data,100  );
        }}else{
            return json_fail('添加失败，你已经有注册记录了',$data,100  );
           }
        }
