<?php

namespace App\Http\Controllers;

use App\Models\innovation_star_registrations;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WkxController extends Controller
{
    public function chaxun(Request $request)            //查询
    {

            $student_id = $request->input('student_id');  //获取名为student_id 的输入参数，并将其赋值给变量 $student_id


            $count=innovation_star_registrations::id_cha($student_id);  //要先写调用的内容，再写判断语句
                       //调用 innovation_star_registrations模型的id_cha方法，并传递 $student_id 作为参数，将返回的结果赋值给变量 $count



            if($count==1) {                                              //判断语句最好先写判断成功后的内容
                $xinxi = innovation_star_registrations::cha($student_id);


                if (is_error($xinxi) == true) {                           //这个is_error相当于报错把
                    return json_fail('查询失败', $xinxi, 100);
                }
                return json_success('查询成功', $xinxi, 200);
            }

            else{

                return json_fail('查询失败,表内未有信息或者有重复的student_id', $count, 100);
                }

            }







    public function xiugai(Request $request)           //修改
    {


        $id = $request->input('id');
        $count=innovation_star_registrations::id_gai($id);

        if ($count==1){

            $xinxi = innovation_star_registrations::gai($id, $request);



            if (is_error($xinxi)==true) {
                return json_fail('修改失败', $xinxi, 100);
            }
            return json_success('修改成功', $xinxi, 200);
            }
        else{

            return json_fail('修改失败,必须输入正确的id才能修改', $count, 100);
        }


    }








    public function shanchu(Request $request)
    {
        $id = $request->input('id');
        $count = innovation_star_registrations::id_shan($id);

        if ($count == 1) {

            $xinxi = innovation_star_registrations::shan($id);

            if (is_error($xinxi)==true) {
                return json_fail('修改失败', $xinxi, 100);
            }
            return json_success('修改成功', $xinxi, 200);
        }
        else{
            return json_fail('删除失败,为输入id或者输入id为空');
        }
    }

}
