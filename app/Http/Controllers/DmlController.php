<?php

namespace App\Http\Controllers;

use App\Model\students;
use App\Model\sciencestarregistrations;
use Illuminate\Http\Request;

class DmlController extends Controller
{
    // 管理查看科研之星申报信息
    public function getOne(Request $request)
    {
        $id = $request->input('id');
        $student = students::find($id);

        if ($student) {
            $data = $student->science_star_registrations;
            if ($data) {
               return json_success('查找成功',$data,100);
            } else {
                return json_fail('查找失败',$data,100);
            }
        } else {
            return json_fail('查找失败',$student,100);
        }
    }
}
