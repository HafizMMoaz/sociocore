<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GlobalCurrency;

class GlobalCurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->addCurrencies();
    }

    public function addCurrencies()
    {
        GlobalCurrency::firstOrCreate([
            'currency_code' => 'PKR'
        ], [
            'currency_name' => 'Rupee',
            'currency_symbol' => 'Rs',
            'currency_code' => 'PKR',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'USD'
        ], [
            'currency_name' => 'Dollars',
            'currency_symbol' => '$',
            'currency_code' => 'USD',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'CNY'
        ], [
            'currency_name' => 'Chinese Yuan',
            'currency_symbol' => '¥',
            'currency_code' => 'CNY',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'GBP'
        ], [
            'currency_name' => 'Pounds',
            'currency_symbol' => '£',
            'currency_code' => 'GBP',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'EUR'
        ], [
            'currency_name' => 'Euros',
            'currency_symbol' => '€',
            'currency_code' => 'EUR',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'INR'
        ], [
            'currency_name' => 'Indian Rupee',
            'currency_symbol' => '₹',
            'currency_code' => 'INR',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'AED'
        ], [
            'currency_name' => 'UAE Dirham',
            'currency_symbol' => 'د.إ',
            'currency_code' => 'AED',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'SAR'
        ], [
            'currency_name' => 'Saudi Riyal',
            'currency_symbol' => '﷼',
            'currency_code' => 'SAR',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'CAD'
        ], [
            'currency_name' => 'Canadian Dollar',
            'currency_symbol' => 'C$',
            'currency_code' => 'CAD',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'AUD'
        ], [
            'currency_name' => 'Australian Dollar',
            'currency_symbol' => 'A$',
            'currency_code' => 'AUD',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'JPY'
        ], [
            'currency_name' => 'Japanese Yen',
            'currency_symbol' => '¥',
            'currency_code' => 'JPY',
            'currency_position' => 'left',
            'no_of_decimal' => 0,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'TRY'
        ], [
            'currency_name' => 'Turkish Lira',
            'currency_symbol' => '₺',
            'currency_code' => 'TRY',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);

        GlobalCurrency::firstOrCreate([
            'currency_code' => 'ZAR'
        ], [
            'currency_name' => 'South African Rand',
            'currency_symbol' => 'R',
            'currency_code' => 'ZAR',
            'currency_position' => 'left',
            'no_of_decimal' => 2,
            'thousand_separator' => ',',
            'decimal_separator' => '.',
        ]);
    }
}
