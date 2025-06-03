<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class LeadsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Lead::with(['branch', 'city', 'district']);

        // Apply filters
        if (!empty($this->filters['name'])) {
            $query->where('name', 'like', '%' . $this->filters['name'] . '%');
        }

        if (!empty($this->filters['phone'])) {
            $query->where('phone', 'like', '%' . $this->filters['phone'] . '%');
        }

        if (!empty($this->filters['email'])) {
            $query->where('email', 'like', '%' . $this->filters['email'] . '%');
        }

        if (!empty($this->filters['city_id'])) {
            $query->where('city_id', $this->filters['city_id']);
        }

        if (!empty($this->filters['branch_id'])) {
            $query->where('branch_id', $this->filters['branch_id']);
        }

        if (!empty($this->filters['district_id'])) {
            $query->where('district_id', $this->filters['district_id']);
        }

        if (!empty($this->filters['date_from'])) {
            $query->whereDate('created_at', '>=', $this->filters['date_from']);
        }

        if (!empty($this->filters['date_to'])) {
            $query->whereDate('created_at', '<=', $this->filters['date_to']);
        }

        return $query;
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

    public function map($lead): array
    {
        return [
            $lead->name,
            $lead->phone,
            $lead->whatsapp_number,
            $lead->email,
            $lead->national_id,
            $lead->branch->name ?? '',
            $lead->city->name ?? '',
            $lead->district->name ?? '',
            $lead->location_link,
        ];
    }
}
