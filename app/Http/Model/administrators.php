<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;//引用Authenticatable类使得DemoModel具有用户认证功能
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Exception;

class administrators extends Authenticatable implements JWTSubject
{//
    protected $table = "administrators";
    public $timestamps = false;//时间戳
    protected $primaryKey = "id";
    protected $guarded = [];

    //不知道有什么用
    use HasFactory;

    //使用模型工厂来创建模型实例

    public function getJWTIdentifier()
    {
        //getKey() 方法用于获取模型的主键值
        return $this->getKey();
    }
    public function getJWTCustomClaims(): array
    {
        return ["role" => "administrators"];////关于登录登出
    }

    public static function zhuce($data)
    {
        try {
            $date = administrators::insert([
                'account' => $data['account'],
                'password' => $data['password'],
                //'created_at'=>now(),
                //'updated_at'=>now(),//时间有问题
            ]);
            return $date;
        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }

    public static function shuliang($account)
    {
        try {
            $dm = administrators::where('account', $account)
                ->select(['account']) // 明确指定列名
                ->count();
            return $dm;
        } catch (Exception $e) {

            return 'error' . $e->getMessage();
        }
    }

}
