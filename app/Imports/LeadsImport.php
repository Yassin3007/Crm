<?php

namespace App\Imports;

use App\Models\Lead;
use App\Models\Branch;
use App\Models\City;
use App\Models\District;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Validators\Failure;

class LeadsImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnFailure
{
    use Importable, SkipsFailures;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Find branch by name
        $branch = Branch::where('name_en', $row['branch'])->orWhere('name_ar', $row['branch'])->first();
        if (!$branch) {
            return null; // Skip this row if branch not found
        }

        // Find city by name
        $city = City::where('name_en', $row['city'])->orWhere('name_ar', $row['city'])->first();
        if (!$city) {
            return null; // Skip this row if city not found
        }

        // Find district by name
        $district = District::where('name_en', $row['district'])->orWhere('name_ar', $row['district'])->first();
        if (!$district) {
            return null; // Skip this row if district not found
        }

        return new Lead([
            'name' => $row['name'],
            'phone' => $row['phone'],
            'whatsapp_number' => $row['whatsapp_number'],
            'email' => $row['email'],
            'national_id' => $row['national_id'],
            'branch_id' => $branch->id,
            'city_id' => $city->id,
            'district_id' => $district->id,
            'location_link' => $row['location_link'] ?? '',
        ]);
    }

    public function rules(): array
    {
        return [];
//        return [
//            'name' => 'required|string|max:255',
//            'phone' => 'required|string|max:255',
//            'whatsapp_number' => 'required|string|max:255',
//            'email' => 'required|email|max:255',
//            'national_id' => 'required|string|max:255',
//            'branch' => 'required|string|exists:branches,name',
//            'city' => 'required|string|exists:cities,name',
//            'district' => 'required|string|exists:districts,name',
//            'location_link' => 'nullable|url',
//        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.required' => 'Name is required',
            'phone.required' => 'Phone is required',
            'whatsapp_number.required' => 'WhatsApp number is required',
            'email.required' => 'Email is required',
            'email.email' => 'Email must be a valid email address',
            'national_id.required' => 'National ID is required',
            'branch.required' => 'Branch is required',
            'branch.exists' => 'Branch does not exist',
            'city.required' => 'City is required',
            'city.exists' => 'City does not exist',
            'district.required' => 'District is required',
            'district.exists' => 'District does not exist',
            'location_link.url' => 'Location link must be a valid URL',
        ];
    }
}
