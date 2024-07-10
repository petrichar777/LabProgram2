<?php

namespace App\Exports;

use App\Models\innovation_star_registrations;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InnovationStarExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return innovation_star_registrations::all();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'students ID',
            'Grade',
            'Major',
            'Class',
            'Name',
            'Company Name',
            'Entity Type',
            'Applicant Ranking',
            'Registration Time',
            'Company Scale',
            'Status',
            'Certificate',
            'Rejection Reason',
        ];
    }
}
