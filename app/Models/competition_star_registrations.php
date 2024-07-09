<?php

namespace App\Models;

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
