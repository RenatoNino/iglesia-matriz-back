<?php

namespace Database\Seeders;

use App\Models\MassType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MassTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now();

        MassType::insert([
            [
                'name' => 'Misa de difuntos',
                'slug' => 'misa-difuntos',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Misa de acción de gracias',
                'slug' => 'misa-accion-gracias',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Misa de gloria',
                'slug' => 'misa-gloria',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Misa de salud',
                'slug' => 'misa-salud',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ]);
    }
}
