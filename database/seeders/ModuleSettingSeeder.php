<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Module;
use App\Models\ModuleSetting;

class ModuleSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run($society): void
    {
        $modules = [
            'Tower',
            'Floor',
            'Apartment',
            'User',
            'Owner',
            'Tenant',
            'Rent',
            'Utility Bills',
            'Common Area Bills',
            'Maintenance',
            'Amenities',
            'Book Amenity',
            'Visitors',
            'Notice Board',
            'Tickets',
            'Parking',
            'Service Provider',
            'Service Time Logging',
            'Assets',

        ];

        $types = ['Admin', 'Manager', 'Owner', 'Tenant', 'Guard'];

        $data = [];
        foreach ($types as $type) {
            foreach ($modules as $module) {
                $data[] = [
                    'society_id' => $society->id,
                    'module_name' => $module,
                    'status' => 'active',
                    'type' => $type,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        ModuleSetting::insert($data);
    }
}
