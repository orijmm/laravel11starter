<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Configuracion inicial
        $setting = Setting::create([
            'name_company' => 'name company',
            'description' => 'description',
            'address' => 'Address 123',
            'phone' => '+56952999999',
            'email' => 'notiene@gmail.com',
            'locale' => 'es',
            'timezone' => 'America/Santiago',
            'state_id' => '109',
            'city_id' => '11109',
            'country_id' => '07',
            'currency_id' => '07',
        ]);
    }
}
