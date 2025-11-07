<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Governorate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
class GovernorateCitySeeder extends Seeder
{
    public function run(): void
    {
        $governorates = [
            'القاهرة' => ['مصر الجديدة', 'مدينة نصر', 'المعادي', 'حلوان', 'العباسية'],
            'الجيزة' => ['الدقي', 'العجوزة', 'الهرم', '6 أكتوبر', 'الشيخ زايد'],
            'الإسكندرية' => ['المنتزه', 'العجمي', 'سيدي جابر', 'الجمرك'],
            'الدقهلية' => ['المنصورة', 'طلخا', 'ميت غمر', 'بلقاس'],
        ];

        foreach ($governorates as $gov => $cities) {
            $govModel = Governorate::create(['name' => $gov]);
            foreach ($cities as $city) {
                City::create([
                    'governorate_id' => $govModel->id,
                    'name' => $city,
                ]);
            }
        }
    }
}