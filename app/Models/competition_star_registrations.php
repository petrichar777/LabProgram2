<?php

namespace App\Models;

<<<<<<< HEAD
use Illuminate\Foundation\Auth\User as Authenticatable;//引用Authenticatable类使得DemoModel具有用户认证功能
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Exception;

 class competition_star_registrations extends Authenticatable implements JWTSubject
{//
    protected $table = "competition_star_registrations";
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

     // 定义与 Student 的多对一关系
     public function student()
     {
         return $this->belongsTo('App\Models\students', 'student_id');
     }

    public static function searchByCompetitionName($competitionName, $studentId)
    {
        // 在模型层中进行查询并返回结果
        return self::where('competition_name', 'like', '%' . $competitionName . '%')
            ->where('student_id', $studentId)
            ->get([
                'grade','major','class','competition_name','registration_time','status','certificate','rejection_reason'
            ])
            ->toArray();
    }


     // 管理员根据过滤条件模糊查询
     public static function searchByFilters($filters)
     {
         try {
             $query = self::query();

             // 根据竞赛名称模糊查询
             if (!empty($filters['competition_name'])) {
                 $query->where('competition_name', 'like', '%' . $filters['competition_name'] . '%');
             }

             // 根据状态查询
             if (!empty($filters['status'])) {
                 $query->where('status', 'like', '%' . $filters['status'] . '%');
             }

             // 加入 students 表中的过滤条件
             $query->whereHas('student', function ($studentQuery) use ($filters) {
                 // 根据姓名模糊查询
                 if (!empty($filters['name'])) {
                     $studentQuery->where('name', 'like', '%' . $filters['name'] . '%');
                 }

                 // 根据专业模糊查询
                 if (!empty($filters['major'])) {
                     $studentQuery->where('major', 'like', '%' . $filters['major'] . '%');
                 }

                 // 根据年级模糊查询
                 if (!empty($filters['grade'])) {
                     $studentQuery->where('grade', 'like', '%' . $filters['grade'] . '%');
                 }

             });
             return $query->get([
                 'grade','major','class','competition_name','registration_time','status','certificate','rejection_reason'
             ]);

         } catch (Exception $e) {
             return 'error'.$e->getMessage();
         }
     }

     public static function Numberofproject($user)
     {
         try {
             $count = competition_star_registrations::where('competition_name',$user['competition_name'])
                 ->where('name',$user['name'])
                 ->count();
             return $count;
         } catch (Exception $e) {
             return 'error' . $e->getMessage();
         }
     }

     public static function increase($user){
         try {
             $data = competition_star_registrations::insert([
                 'student_id' => $user['student_id'],
                 'grade' => $user['grade'],
                 'major' => $user['major'],
                 'class' => $user['class'],
                 'name' => $user['name'],
                 'competition_name' => $user['competition_name'],
                 'registration_time' => $user['time'],
                 'status' => 0,
                 'certificate' => 0,
                 'rejection_reason' => 0,
             ]);
             return $data;
         } catch (Exception $e) {
             return 'error' . $e->getMessage();
         }
     }
}

=======
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class competition_star_registrations extends Model
{
    use HasFactory;

    // 定义表名
    protected $table = 'competition_star_registrations';

    // 定义可以批量赋值的字段
    protected $fillable = [
        'student_id',
        'grade',
        'major',
        'class',
        'name',
        'competition_name',
        'registration_time',
    ];
}
>>>>>>> 0015bfb2bb49bf44b98d4527abea4ffd161c1eaf
