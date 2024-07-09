<?php

namespace App\Exports;

use App\Models\Company;
use App\Models\Competition;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class YourExportClassNameShuangc implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $teacherIds;

    public function __construct($teacherIds)
    {
        $this->teacherIds = $teacherIds;
    }

    public function collection()
    {
        return Company::whereIn('id', $this->teacherIds)
            ->get()
            ->map(function ($teacher) {
                return [
                    '年级' => $teacher->grade,
                    '专业' => $teacher->major,
                    '班级' => $teacher->class,
                    '姓名' => $teacher->stuname,
                    '注册公司名称' => $teacher->companyname,
                    '虚拟/实体' => $teacher->vp,
                    '申报人排名' => $teacher->ranking,
                    '注册时间' => $teacher->signuptime,
                    '公司规模' => $teacher->scale,
                    '佐证材料' => $teacher->url,
                    '状态' => $teacher->state,
                ];
            });
    }

    public function headings(): array
    {
        return [
            '年级',
            '专业',
            '班级',
            '姓名',
            '注册公司名称',
            '虚拟/实体',
            '申报人排名',
            '注册时间',
            '公司规模',
            '佐证材料',
            '状态',
        ];
    }
}
