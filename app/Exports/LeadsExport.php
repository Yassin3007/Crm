<?php

namespace App\Exports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;

class LeadsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Lead::with(['branch', 'city', 'district']);

        // Apply filters from request
        if ($this->request->filled('name')) {
            $query->where('name', 'like', '%' . $this->request->name . '%');
        }

        if ($this->request->filled('phone')) {
            $query->where('phone', 'like', '%' . $this->request->phone . '%');
        }

        if ($this->request->filled('email')) {
            $query->where('email', 'like', '%' . $this->request->email . '%');
        }

        if ($this->request->filled('city_id')) {
            $query->where('city_id', $this->request->city_id);
        }

        if ($this->request->filled('branch_id')) {
            $query->where('branch_id', $this->request->branch_id);
        }

        if ($this->request->filled('district_id')) {
            $query->where('district_id', $this->request->district_id);
        }

        if ($this->request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $this->request->date_from);
        }

        if ($this->request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $this->request->date_to);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Phone',
            'WhatsApp Number',
            'Email',
            'National ID',
            'Branch',
            'City',
            'District',
            'Location Link',
            'Created At',
        ];
    }

    public function map($lead): array
    {
        return [
            $lead->id,
            $lead->name,
            $lead->phone,
            $lead->whatsapp_number,
            $lead->email,
            $lead->national_id,
            $lead->branch->name ?? '',
            $lead->city->name ?? '',
            $lead->district->name ?? '',
            $lead->location_link,
            $lead->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
