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
}
