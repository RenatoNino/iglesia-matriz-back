<?php

namespace Database\Seeders;

use App\Models\SystemConfiguration;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemConfiguration::create([
            'key' => 'application_name',
            'name' => 'Nombre de la institución',
            'type' => 'string',
            'value' => 'Instutución',
        ]);
        SystemConfiguration::create([
            'key' => 'logo',
            'name' => 'Logo',
            'type' => 'string',
            'value' => null,
        ]);
        SystemConfiguration::create([
            'key' => 'favicon',
            'name' => 'Favicon',
            'type' => 'string',
            'value' => null,
        ]);
        SystemConfiguration::create([
            'key' => 'banner',
            'name' => 'Banner',
            'type' => 'string',
            'value' => null,
        ]);
        SystemConfiguration::create([
            'key' => 'primary_color',
            'name' => 'Color Primario',
            'type' => 'string',
            'value' => '#7367F0',
        ]);
    }
}
