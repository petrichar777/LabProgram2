<?php

namespace App\Http\Model;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class students extends Model
{
    use HasFactory;

    // 定义表名
    protected $table = 'students';

    // 定义可以批量赋值的字段
    protected $fillable = [
        'account',
        'password',
        'grade',
        'major',
        'class',
        'name',
        'email'
    ];
    protected $hidden = [
        'password',
    ];

    // 设置与guestinfo的关联方法，方法名建议使用被关联表的名字


    public static function Finding($data)
    {
        try {
            $data = students::where('grade', $data['grade'])
                ->where('name', $data['name'])
                ->where('major', $data['major'])
                ->where('class', $data['class'])
                ->first();
            return $data;

        } catch (Exception $e) {
            return 'error ' . $e->getMessage();
        }
    }
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
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    // 验证凭证的静态方法
    public static function validateCredentials($account, $password)
    {
        try {
            // 查找用户
            $user = self::where('account', $account)->first();

            // 检查用户是否存在以及密码是否正确
            if ($user && Hash::check($password, $user->password)) {
                // 如果密码正确，返回 true
                return true;
            }

            // 如果用户不存在或密码不正确，返回 false
            return false;

        } catch (Exception $e) {
            // 处理异常，记录日志或返回错误信息
            // Log::error('Error validating credentials: ' . $e->getMessage());
            return false;
        }
    }
}
