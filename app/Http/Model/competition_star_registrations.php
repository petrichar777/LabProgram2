<?php

namespace App\Http\Model;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Carbon\Carbon;

//引用Authenticatable类使得DemoModel具有用户认证功能

class competition_star_registrations extends Authenticatable implements JWTSubject
{//
    protected $table = "competition_star_registrations";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded = [];

    //不知道有什么用
    use HasFactory;

    //使用模型工厂来创建模型实例
    // 定义表名


    // 定义可以批量赋值的字段
    protected $fillable = [
        'student_id',
        'grade',
        'major',
        'class',
        'name',
        'competition_name',
        'registration_time',];
    public function getJWTIdentifier()
    {
        //getKey() 方法用于获取模型的主键值
        return $this->getKey();
    }

    //返回一个包含自定义声明的关联数组。
    public function getJWTCustomClaims()
    {
        return ['role => competition_star_registrations'];
    }

    public static function AddStudent($userdata)//学生新增
    {
        try {
            // 检查是否有相同的 name 和 competition_name
            $existingRecord = competition_star_registrations::where('name', $userdata['name'])
                ->where('competition_name', $userdata['competition_name'])
                ->first();

            if ($existingRecord) {
                return [
                    'status' => 'fail',
                    'message' => '报名失败！该生在此竞赛中已报名',
                    'data' => $existingRecord
                ];
            }

            // 插入数据
            $data = competition_star_registrations::create([
                'grade' => $userdata['grade'],
                'major' => $userdata['major'],
                'class' => $userdata['class'],
                'name' => $userdata['name'],
                'competition_name' => $userdata['competition_name'],
                'status' => $userdata['status'],
                'registration_time' => Carbon::now(), // 使用 Carbon::now() 获取当前时间
                'student_id' => $userdata['student_id']
            ]);

            if ($data) {
                return [
                    'status' => 'success',
                    'message' => '注册成功!',
                    'data' => $data
                ];
            } else {
                return [
                    'status' => 'fail',
                    'message' => '注册失败',
                    'data' => null
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => 'error',
                'message' => '注册失败，错误: ' . $e->getMessage(),
                'data' => null
            ];
        }
    }

    // 获取全部数据的方法
    public static function getAllData()//老师查看
    {
        return self::all([
            'grade', 'major', 'class', 'name', 'competition_name', 'registration_time', 'status', 'certificate', 'rejection_reason', 'created_at', 'updated_at'
        ]);
    }


    public static function FindDate($id)//学生查询
    {
        try {
            $data = competition_star_registrations::where('student_id', $id)
                ->get([
                    'grade', 'major', 'class', 'name', 'competition_name', 'registration_time', 'status', 'certificate', 'rejection_reason', 'created_at', 'updated_at'
                ]);
            return $data;

        } catch (Exception $e) {
            return 'error ' . $e->getMessage();
        }
    }

    public static function editCertificate($data)
    {
        try {
            $data = competition_star_registrations::where('student_id', $data['student_id'])
                ->where('competition_name', $data['competition_name'])
                ->update([
                    'certificate' => $data['certificate'],
                    'status' => $data['status'],
                    'rejection_reason' => $data['rejection_reason'],
                ]);
            return $data;
        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }

    public static function editRejection_reason($data)//老师审批
    {
        try {
            $data = competition_star_registrations::where('student_id', $data['student_id'])
                ->where('competition_name', $data['competition_name'])
                ->update([
                    'status' => $data['status'],
                    'rejection_reason' => $data['rejection_reason'],
                ]);
            return $data;
        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }

}
