<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class science_star_registrations extends Model
{
    use HasFactory;

    // 定义表名
    protected $table = 'science_star_registrations';

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
    ];
}
