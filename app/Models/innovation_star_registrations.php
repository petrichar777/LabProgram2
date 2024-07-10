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
}
