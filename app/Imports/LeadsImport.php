<?php

namespace App\Imports;

use App\Models\Lead;
use App\Models\Branch;
use App\Models\City;
use App\Models\District;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Illuminate\Validation\Rule;

class LeadsImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;

    protected $rowCount = 0;

    public function model(array $row)
    {
        // Find related models by name
        $branch = Branch::where('name_en', $row['branch_name'])->orWhere('name_ar', $row['branch_name'])->first();
        $city = City::where('name_en', $row['city_name'])->orWhere('name_ar', $row['city_name'])->first();
        $district = District::where('name_en', $row['district_name'])->orWhere('name_ar', $row['district_name'])->first();

        if (!$branch || !$city || !$district) {
            return null; // This will be caught by validation
        }

        $this->rowCount++;

        return new Lead([
            'name' => $row['name'],
            'phone' => $row['phone'],
            'whatsapp_number' => $row['whatsapp_number'],
            'email' => $row['email'],
            'national_id' => $row['national_id'],
            'branch_id' => $branch->id,
            'city_id' => $city->id,
            'district_id' => $district->id,
            'location_link' => $row['location_link'] ?? null,
        ]);
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'phone' => [
                'required',
                'max:255',
                Rule::unique('leads', 'phone')
            ],
            'whatsapp_number' => 'nullable|max:255',
            'email' => 'required|email|max:255',
            'national_id' => 'required|max:255',
            'branch_name' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $exists = Branch::where('name_en', $value)
                        ->orWhere('name_ar', $value)
                        ->exists();
                    if (!$exists) {
                        $fail('The branch name does not exist.');
                    }
                }
            ],
            'city_name' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $exists = City::where('name_en', $value)
                        ->orWhere('name_ar', $value)
                        ->exists();
                    if (!$exists) {
                        $fail('The City name does not exist.');
                    }
                }
            ],
            'district_name' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $exists = District::where('name_en', $value)
                        ->orWhere('name_ar', $value)
                        ->exists();
                    if (!$exists) {
                        $fail('The District name does not exist.');
                    }
                }
            ],
            'location_link' => 'nullable|url',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'phone.unique' => 'The phone number must be unique.',
            'branch_name.exists' => 'The branch name does not exist.',
            'city_name.exists' => 'The city name does not exist.',
            'district_name.exists' => 'The district name does not exist.',
        ];
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }

    public function getFailures()
    {
        return $this->failures();
    }
}
