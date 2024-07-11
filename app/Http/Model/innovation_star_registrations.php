<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class innovation_star_registrations extends Model
{
    use HasFactory;

    // 定义表名
    protected $table = 'innovation_star_registrations';

    // 定义可以批量赋值的字段
    protected $fillable = [
        'grade',
        'major',
        'class',
        'name',
        'company_name',
        'entity_type',
        'registration_time',
        'company_scale',
    ];
     public static function addlnnovationStar($data)
    {
        try {
            $data = DB::table('innovation_star_registrations')
                ->insert([
                    'grade' => $data['grade'],
                    'major' => $data['major'],
                    'class' => $data['class'],
                    'name' => $data['name'],
                    'entity_type' => $data['entity_type'], // 实体，虚体
                    'company_name' => $data['company_name'], // 公司名称
                    'registration_time' => now(), // 公司注册时间
                    'certificate' => $data['certificate'], // 证书链接
                    'student_id' => $data['student_id'], // 关联表
                    'applicant_ranking' => 0,
                    'company_scale' => 0,
                    'status' => 0,
                    'rejection_reason' => '0' // 拒绝原因，根据实际情况设定
                ]);
            return $data;
        } catch (\Exception $e) {
            // 处理异常
            return false;
        }
    }

    public static function editRejection_reason($data)
    {
        try {
            $data = innovationstarregistrations::where('student_id',$data['student_id'])
                ->where('company_name',$data['company_name'])
                ->update([
                    'status' => $data['status'],
                    'rejection_reason' => $data['rejection_reason'],
                ]);
            return $data;
        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }
    public static function  editCertificate($data)
    {
        try {
            $data = innovationstarregistrations::where('student_id',$data['student_id'])
                ->where('company_name',$data['company_name'])
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
