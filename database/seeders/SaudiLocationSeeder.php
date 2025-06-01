<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use App\Models\City;
use App\Models\District;

class SaudiLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            // Use a simpler approach - fetch from a more structured source
            $this->command->info('Fetching Saudi Arabia location data...');

            // Alternative API that might have better structure
            $response = Http::timeout(30)->get('https://api.github.com/repos/homaily/Saudi-Arabia-Regions-Cities-and-Districts/contents/json');

            if ($response->successful()) {
                $this->command->info('Using structured data approach...');
                $this->seedStructuredData();
            } else {
                $this->command->info('Using comprehensive manual data...');
                $this->seedComprehensiveData();
            }

        } catch (\Exception $e) {
            $this->command->error('Error: ' . $e->getMessage());
            $this->command->info('Using comprehensive manual data...');
            $this->seedComprehensiveData();
        }
    }

    private function seedStructuredData(): void
    {
        // This method can be expanded when we have better API structure
        $this->seedComprehensiveData();
    }

    private function seedComprehensiveData(): void
    {
        $saudiCitiesWithDistricts = [
            'Riyadh' => [
                'name_ar' => 'الرياض',
                'districts' => [
                    ['name_en' => 'Al Olaya', 'name_ar' => 'العليا'],
                    ['name_en' => 'Al Malaz', 'name_ar' => 'الملز'],
                    ['name_en' => 'Al Naseem', 'name_ar' => 'النسيم'],
                    ['name_en' => 'Al Wurud', 'name_ar' => 'الورود'],
                    ['name_en' => 'Al Sahafa', 'name_ar' => 'الصحافة'],
                    ['name_en' => 'King Fahd District', 'name_ar' => 'حي الملك فهد'],
                    ['name_en' => 'Al Hamra', 'name_ar' => 'الحمراء'],
                    ['name_en' => 'Al Nakheel', 'name_ar' => 'النخيل'],
                ]
            ],
            'Jeddah' => [
                'name_ar' => 'جدة',
                'districts' => [
                    ['name_en' => 'Al Balad', 'name_ar' => 'البلد'],
                    ['name_en' => 'Al Corniche', 'name_ar' => 'الكورنيش'],
                    ['name_en' => 'Al Rawdah', 'name_ar' => 'الروضة'],
                    ['name_en' => 'Al Zahra', 'name_ar' => 'الزهراء'],
                    ['name_en' => 'Al Salamah', 'name_ar' => 'السلامة'],
                    ['name_en' => 'Obhur', 'name_ar' => 'أبحر'],
                    ['name_en' => 'Al Sharafeyah', 'name_ar' => 'الشرفية'],
                ]
            ],
            'Mecca' => [
                'name_ar' => 'مكة المكرمة',
                'districts' => [
                    ['name_en' => 'Al Haram', 'name_ar' => 'الحرم'],
                    ['name_en' => 'Ajyad', 'name_ar' => 'أجياد'],
                    ['name_en' => 'Al Misfalah', 'name_ar' => 'المسفلة'],
                    ['name_en' => 'Az Zahir', 'name_ar' => 'الزاهر'],
                    ['name_en' => 'Ash Shubaikah', 'name_ar' => 'الشبيكة'],
                ]
            ],
            'Medina' => [
                'name_ar' => 'المدينة المنورة',
                'districts' => [
                    ['name_en' => 'Al Haram', 'name_ar' => 'الحرم'],
                    ['name_en' => 'Quba', 'name_ar' => 'قباء'],
                    ['name_en' => 'Al Awali', 'name_ar' => 'العوالي'],
                    ['name_en' => 'Al Aqiq', 'name_ar' => 'العقيق'],
                ]
            ],
            'Dammam' => [
                'name_ar' => 'الدمام',
                'districts' => [
                    ['name_en' => 'Al Faisaliah', 'name_ar' => 'الفيصلية'],
                    ['name_en' => 'Al Shatea', 'name_ar' => 'الشاطئ'],
                    ['name_en' => 'Al Adamah', 'name_ar' => 'الآدمة'],
                    ['name_en' => 'Al Noor', 'name_ar' => 'النور'],
                ]
            ],
            'Khobar' => [
                'name_ar' => 'الخبر',
                'districts' => [
                    ['name_en' => 'Al Corniche', 'name_ar' => 'الكورنيش'],
                    ['name_en' => 'Al Olaya', 'name_ar' => 'العليا'],
                    ['name_en' => 'Al Rakah', 'name_ar' => 'الراكة'],
                    ['name_en' => 'Thuqbah', 'name_ar' => 'الثقبة'],
                ]
            ],
            'Taif' => [
                'name_ar' => 'الطائف',
                'districts' => [
                    ['name_en' => 'Al Hawiyah', 'name_ar' => 'الحوية'],
                    ['name_en' => 'Al Shafa', 'name_ar' => 'الشفا'],
                    ['name_en' => 'Al Rudaf', 'name_ar' => 'الرداف'],
                ]
            ],
            'Buraidah' => [
                'name_ar' => 'بريدة',
                'districts' => [
                    ['name_en' => 'Al Nakheel', 'name_ar' => 'النخيل'],
                    ['name_en' => 'Al Iskan', 'name_ar' => 'الإسكان'],
                    ['name_en' => 'Al Safra', 'name_ar' => 'الصفراء'],
                ]
            ],
            'Tabuk' => [
                'name_ar' => 'تبوك',
                'districts' => [
                    ['name_en' => 'Al Wurud', 'name_ar' => 'الورود'],
                    ['name_en' => 'Sultana', 'name_ar' => 'سلطانة'],
                    ['name_en' => 'Al Nakheel', 'name_ar' => 'النخيل'],
                ]
            ],
            'Abha' => [
                'name_ar' => 'أبها',
                'districts' => [
                    ['name_en' => 'Al Manhal', 'name_ar' => 'المنهل'],
                    ['name_en' => 'Al Nsab', 'name_ar' => 'النصب'],
                    ['name_en' => 'As Sadah', 'name_ar' => 'السدة'],
                ]
            ],
            'Najran' => [
                'name_ar' => 'نجران',
                'districts' => [
                    ['name_en' => 'Al Faisaliah', 'name_ar' => 'الفيصلية'],
                    ['name_en' => 'Qoshah', 'name_ar' => 'قوشة'],
                ]
            ],
            'Jizan' => [
                'name_ar' => 'جازان',
                'districts' => [
                    ['name_en' => 'Al Corniche', 'name_ar' => 'الكورنيش'],
                    ['name_en' => 'Al Rawdah', 'name_ar' => 'الروضة'],
                ]
            ],
            'Hail' => [
                'name_ar' => 'حائل',
                'districts' => [
                    ['name_en' => 'Al Andalus', 'name_ar' => 'الأندلس'],
                    ['name_en' => 'Gharnata', 'name_ar' => 'غرناطة'],
                ]
            ],
            'Al Jubail' => [
                'name_ar' => 'الجبيل',
                'districts' => [
                    ['name_en' => 'Industrial City', 'name_ar' => 'المدينة الصناعية'],
                    ['name_en' => 'Al Deffi', 'name_ar' => 'الدفي'],
                ]
            ],
            'Yanbu' => [
                'name_ar' => 'ينبع',
                'districts' => [
                    ['name_en' => 'Industrial City', 'name_ar' => 'المدينة الصناعية'],
                    ['name_en' => 'Al Balad', 'name_ar' => 'البلد'],
                ]
            ],
        ];

        foreach ($saudiCitiesWithDistricts as $cityName => $cityData) {
            $this->command->info("Seeding {$cityName}...");

            // Update or create the city
            $city = City::updateOrCreate(
                ['name_en' => $cityName], // Search criteria
                [
                    'name_ar' => $cityData['name_ar'],
                    'is_active' => true,
                ]
            );

            $this->command->info("City {$cityName} " . ($city->wasRecentlyCreated ? 'created' : 'updated'));

            // Create/update districts for this city
            foreach ($cityData['districts'] as $district) {
                $districtModel = District::updateOrCreate(
                    [
                        'name_en' => $district['name_en'],
                        'city_id' => $city->id
                    ], // Search criteria
                    [
                        'name_ar' => $district['name_ar'],
                        'is_active' => true,
                    ]
                );

                $this->command->info("  - District {$district['name_en']} " . ($districtModel->wasRecentlyCreated ? 'created' : 'updated'));
            }
        }

        $this->command->info('Saudi Arabia cities and districts seeded successfully!');
        $this->command->info('Total cities: ' . City::count());
        $this->command->info('Total districts: ' . District::count());
    }
}
