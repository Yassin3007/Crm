<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LeadsTemplateExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        // Return empty array to create just headers
        return [];
    }

    public function headings(): array
    {
        return [
            'name',
            'phone',
            'whatsapp_number',
            'email',
            'national_id',
            'branch_name',
            'city_name',
            'district_name',
            'location_link',
        ];
    }
}
