<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;//引用Authenticatable类使得DemoModel具有用户认证功能
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Exception;
use Illuminate\Database\Eloquent\Model;

class science_star_registrations extends Authenticatable implements JWTSubject
{
    // 定义可以批量赋值的字段
    protected $fillable = [
        'id',
        'student_id',
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
    protected $table = "science_star_registrations";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded = [];

    //不知道有什么用
    use HasFactory;
    public function getJWTIdentifier()
    {
        //getKey() 方法用于获取模型的主键值
        return $this->getKey();
    }

    //返回一个包含自定义声明的关联数组。
    public function getJWTCustomClaims()
    {
        return ['role' => 'students'];
    }

    public function guest(){
        // hasOne(被关联的名命空间，关联外键，关联的主键)
        return $this->belongsTo('App\Models\students','student_id','id');
    }

    // 定义与 students 的多对一关系
    public function student()
    {
        return $this->belongsTo('App\Models\students', 'student_id');
    }

    // 根据项目类别模糊查询
    public static function searchByProjectCategory($projectCategory, $studentId)
    {
        return self::where('project_category', 'like', '%' . $projectCategory . '%')
            ->where('student_id', $studentId)
            ->get([
                'grade','major','class','project_category','project_name','approval_time','status','certificate','rejection_reason'
            ])
            ->toArray();
    }

    // 根据过滤条件进行查询
    public static function searchByFilters($filters)
    {
        try {
            $query = self::query();

            if (!empty($filters['name'])) {
                $query->whereHas('student', function($q) use ($filters) {
                    $q->where('name', 'like', '%' . $filters['name'] . '%');
                });
            }

            if (!empty($filters['major'])) {
                $query->whereHas('student', function($q) use ($filters) {
                    $q->where('major', 'like', '%' . $filters['major'] . '%');
                });
            }

            if (!empty($filters['project_category'])) {
                $query->where('project_category', 'like', '%' . $filters['project_category'] . '%');
            }

            if (!empty($filters['status'])) {
                $query->where('status', 'like', '%' . $filters['status'] . '%');
            }

            if (!empty($filters['project_name'])) {
                $query->where('project_name', 'like', '%' . $filters['project_name'] . '%');
            }

            if (!empty($filters['approval_time'])) {
                $query->where('approval_time', 'like', '%' . $filters['approval_time'] . '%');
            }
            return $query->get([
                'grade','major','class','project_category','project_name','approval_time','status','certificate','rejection_reason'
            ]);

        } catch (Exception $e) {
            return 'error'.$e->getMessage();
        }
    }

    //寻找是否重复报名项目
    public static function Numberofproject($user)
    {
        try {
            $count = science_star_registrations::where('project_name',$user['project_name'])
                ->where('name',$user['name'])
                ->count();
            return $count;
        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }

    //将报名信息插入数据库
    public static function increase($user){
        try {
            $data = science_star_registrations::insert([
                'student_id' => $user['student_id'],
                'grade' => $user['grade'],
                'major' => $user['major'],
                'class' => $user['class'],
                'name' => $user['name'],
                'project_category' => $user['project_category'],
                'project_name' => $user['project_name'],
                'approval_time' => now(),
                'status' => 0,
                'certificate' => 0,
                'rejection_reason' => 0,
                ]);
            return $data;
        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }

    public static function FindCreatedtime($user){
        try {
            $time = science_star_registrations::where('project_name',$user['project_name'])
            ->select('approval_time')
                ->first();
            return $time;
        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }

    public static function editRejection_reason($data)
    {
        try {
            $data = science_star_registrations::where('student_id',$data['student_id'])
                ->where('project_name',$data['project_name'])
                ->update([
                    'approval_time' => $data['time'],
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
            $data = science_star_registrations::where('student_id',$data['student_id'])
                ->where('project_name',$data['project_name'])
                ->update([
                    'certificate' => $data['certificate'],
                    'approval_time' => $data['time'],
                    'status' => $data['status'],
                    'rejection_reason' => $data['rejection_reason'],
                ]);
            return $data;
        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }
      /*关联表*/
    protected $table = 'science_star_registrations';
    public $timestamps = false;
  
    public function administrators()
    {
        return $this->belongsTo(students::class, 'student_id', 'id');
    }
}



