<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class administrators extends Model
{
    protected $table = "administrators";
    public $timestamps = true;
    protected $primaryKey = "id";
    protected $guarded = [];

    use HasFactory;
}
