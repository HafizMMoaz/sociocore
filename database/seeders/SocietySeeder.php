<?php

namespace Database\Seeders;

use App\Models\Society;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use App\Models\Country;
use Illuminate\Support\Str;
use App\Models\OnboardingStep;

class SocietySeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $country = Country::where('countries_code', 'PK')->first();

        $count = 1;

        if (!App::environment('development')) {
            $count = 5;
        }

        $societyNames = [
            'DHA Residency',
            'Bahria Town Villas',
            'Gulberg Greens',
            'Lake City Lahore',
            'Park View Society',
            'Wapda Town',
            'Askari Housing Society',
            'Johar Town Residencia',
            'Faisal Town',
            'Model Town Extension',
            'Al Rehman Garden',
            'Iqbal Avenue',
            'Palm City Islamabad',
            'Capital Smart City',
            'Blue World City',
            'Saima Arabian Villas',
            'Naval Anchorage',
            'Eden Housing Scheme',
            'Punjab Cooperative Housing Society',
            'Green Town Lahore',
        ];

        for ($i = 0; $i < $count; $i++) {
            $this->command->info('Seeding Society: ' . ($i + 1));

            $societyName = $i == 0 ? 'Demo Society' : $societyNames[$i] ?? fake()->company();

            $society = new Society();
            $society->name = $societyName;
            $society->address = fake()->address();
            $society->phone_number = fake()->e164PhoneNumber();
            $society->timezone = 'Asia/Karachi';
            $society->theme_hex = '#01796f';
            $society->theme_rgb = '1, 121, 111';
            $society->email = str()->slug($societyName, '.') . '@example.com';
            $society->key = Str::random(32);
            $society->country_id = $country->id;
            $society->package_id = 1;
            $society->package_type = 'annual';
            $society->about_us = Society::ABOUT_US_DEFAULT_TEXT;
            $society->facebook_link = 'https://www.facebook.com/';
            $society->instagram_link = 'https://www.instagram.com/';
            $society->twitter_link = 'https://www.twitter.com/';
            $society->save();

            OnboardingStep::where('society_id', $society->id)->update([
                'add_tower_completed' => 1,
                'add_floor_completed' => 1,
                'add_apartment_completed' => 1,
                'add_parking_completed' => 1
            ]);
        }
    }
}
