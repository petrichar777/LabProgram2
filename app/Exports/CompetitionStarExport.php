<?php

namespace App\Exports;

use App\Models\competition_star_registrations;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CompetitionStarExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return competition_star_registrations::all();
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
            'Competition Name',
            'Registration Time',
            'Status',
            'Certificate',
            'Rejection Reason',
        ];
    }
}
