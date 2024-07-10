<?php

namespace App\Exports;

use App\Models\science_star_registrations;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ScienceStarExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return science_star_registrations::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Student ID',
            'Grade',
            'Major',
            'Class',
            'Name',
            'Project Category',
            'Project Name',
            'Approval Time',
            'Ranking',
            'Total People',
            'Status',
            'Certificate',
            'Rejection Reason',
        ];
    }
}
