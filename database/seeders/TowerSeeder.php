<?php

namespace Database\Seeders;

use App\Models\Tower;
use App\Models\Society;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TowerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run($society): void
    {
        $towerNames = [
            'Al Noor Tower',
            'Al Rehman Heights',
            'Al Hafeez Tower',
            'Rafi Heights',
            'Saima Tower',
            'Falcon Tower',
            'Civic Heights',
            'Executive Tower',
            'Grand Heights',
            'City Tower',
            'Royal Residency Tower',
            'Prime Heights',
            'Sky View Tower',
            'Elite Tower',
            'Capital Heights',
            'Pearl Tower',
            'Plaza Heights',
            'Business Tower',
            'Trade Center Tower',
            'Icon Tower'
        ];

        foreach (array_slice($towerNames, 0, 5) as $towerName) {
            Tower::create([
                'tower_name' => $towerName,
                'society_id' => $society->id,
            ]);
        }
    }
}
