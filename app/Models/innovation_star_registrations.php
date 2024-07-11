<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Exception;

class innovation_star_registrations extends Model
{
    use HasFactory;

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

    public $timestamps = false;
    protected $primaryKey = 'id';

    // 定义与 students 的多对一关系
    public function student()
    {
        return $this->belongsTo('App\Models\students', 'student_id');
    }

    // 根据公司名称模糊查询
    public static function searchByCompanyName($companyName, $studentId)
    {
        return self::where('company_name', 'like', '%' . $companyName . '%')
            ->where('student_id', $studentId)
            ->get([
                'grade','major','class','company_name','entity_type','registration_time','company_scale','status','certificate','rejection_reason'
            ])
            ->toArray();
    }

    // 根据过滤条件模糊查询
    public static function searchByFilters($filters)
    {
        try {
            $query = self::query();

            // 根据公司名称模糊查询
            if (!empty($filters['company_name'])) {
                $query->where('company_name', 'like', '%' . $filters['company_name'] . '%');
            }

            // 根据状态查询
            if (!empty($filters['status'])) {
                $query->where('status', 'like', '%' . $filters['status'] . '%');
            }

            // 根据实体类型查询
            if (!empty($filters['entity_type'])) {
                $query->where('entity_type', 'like', '%' . $filters['entity_type'] . '%');
            }

            // 根据公司规模查询
            if (!empty($filters['company_scale'])) {
                $query->where('company_scale', 'like', '%' . $filters['company_scale'] . '%');
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
                'grade','major','class','company_name','entity_type','registration_time','company_scale','status','certificate','rejection_reason'
            ]);

        } catch (Exception $e) {
            return 'error'.$e->getMessage();
        }
    }

    // 下面是你提供的其他静态方法，我假设它们是正确的
    // 请确认它们的实现与你预期的一致

    public static function id_cha($student_id)
    {
        try {
            $xinxi = innovation_star_registrations::where('student_id', $student_id)->count();
            return $xinxi;
        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }

    public static function cha($student_id)
    {
        try {
            $xinxi = innovation_star_registrations::where('student_id', $student_id)
                ->select(
                    'id',
                    'grade',
                    'major',
                    'class',
                    'name',
                    'company_name',
                    'entity_type',
                    'registration_time',
                    'company_scale',
                    'status',
                    'certificate',
                    'rejection_reason'
                )
                ->get();
            return $xinxi;
        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }

    public static function id_gai($id)
    {
        try {
            $xinxi = innovation_star_registrations::where('id', $id)->count();
            return $xinxi;
        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }

    public static function gai($id, $request)
    {
        $xinxi = innovation_star_registrations::where('id', $id)->first();

        try {
            $xinxi->update([
                'grade' => $request['grade'],
                'class' => $request['class'],
                'name' => $request['name'],
                'company_name' => $request['company_name'],
                'entity_type' => $request['entity_type'],
                'registration_time' => $request['registration_time'],
                'company_scale' => $request['company_scale']
            ]);

            $xinxi = innovation_star_registrations::where('id', $id)->first();
            return $xinxi;
        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }

    public static function id_shan($id)
    {
        try {
            $xinxi = innovation_star_registrations::where('id', $id)->count();
            return $xinxi;
        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }

    public static function shan($id)
    {
        try {
            $xinxi = innovation_star_registrations::where('id', $id)->delete();
            return $xinxi;
        } catch (Exception $e) {
            return 'error' . $e->getMessage();
        }
    }
}

