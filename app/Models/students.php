<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;//引用Authenticatable类使得DemoModel具有用户认证功能
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Exception;

 class students extends Authenticatable implements JWTSubject
{//
    protected $table = "students";
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

     public function guestinfo1(){
        // hasOne(被关联的名命空间，关联外键，关联的主键)
        //        hasOne
        //用途：hasOne 用于定义当前模型拥有另一个模型的关系。通常用于表示一对一关系中的“主”方。
        //外键位置：外键在另一个模型中。
        //方向：另一个模型指向当前模型。
         return $this->hasOne('App\Models\competition_star_registrations','student_id','id');
     }

     public function guestinfo2(){
         // hasOne(被关联的名命空间，关联外键，关联的主键)
//        hasOne
//用途：hasOne 用于定义当前模型拥有另一个模型的关系。通常用于表示一对一关系中的“主”方。
//外键位置：外键在另一个模型中。
//方向：另一个模型指向当前模型。
         return $this->hasOne('App\Models\science_star_registrations','student_id','id');
     }

     // 定义与 CompetitionStarRegistration 的一对多关系
     public function competitionRegistrations()
     {
         return $this->hasMany('App\Models\competition_star_registrations', 'student_id');
     }

     // 定义与 InnovationStarRegistration 的一对多关系
     public function innovationRegistrations()
     {
         return $this->hasMany('App\Models\innovation_star_registrations', 'student_id');
     }

     // 定义与 ScienceStarRegistration 的一对多关系
     public function scienceRegistrations()
     {
         return $this->hasMany('App\Models\science_star_registrations', 'student_id');
     }

     //查找学生的student_id
     public static function findstudent_id($user){
         try {
             $data = students::where('name',$user['name'])
                 ->where('grade',$user['grade'])
                 ->where('major',$user['major'])
                 ->where('class',$user['class'])
                 ->first();
             return $data;
         } catch (Exception $e) {
             return 'error' . $e->getMessage();
         }
     }


//     public static function WdwUserCheckNumber($account){
//         try {
//             $count = students::select('account')
//                 ->where('account', $account)
//                 ->count();
//             return $count;
//         } catch (Exception $e) {
//             return 'error' . $e->getMessage();
//         }
//     }

//     public static function WdwcreateUser($user)
//     {
//         try {
//             $data = students::insert([
//                 'account' => $user['account'],
//                 'password' =>  bcrypt($user['password']),
//                 'grade' => $user['grade'],
//                 'major' => $user['major'],
//                 'class' => $user['class'],
//                 'name' => $user['name'],
//                 'email'=>$user['email'],
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ]);
//             return $data;
//
//         } catch (Exception $e) {
//             return 'error'.$e->getMessage();
//         }
//     }

     // 根据姓名、专业、年级进行模糊查询
    public static function searchStudents($filters)
    {
        $query = self::query();

        // 根据姓名模糊查询
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        // 根据专业模糊查询
        if (!empty($filters['major'])) {
            $query->where('major', 'like', '%' . $filters['major'] . '%');
        }

        // 根据年级模糊查询
        if (!empty($filters['grade'])) {
            $query->where('grade', 'like', '%' . $filters['grade'] . '%');
        }

        return $query;
    }
}

