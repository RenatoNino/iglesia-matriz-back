<?php

namespace Database\Seeders;

use App\Models\IntentionType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IntentionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now();

        IntentionType::insert([
            [
                'name' => 'Difuntos',
                'slug' => 'difuntos',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Acción de gracias',
                'slug' => 'accion-gracias',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Gloria',
                'slug' => 'gloria',
                'created_at' => $date,
                'updated_at' => $date,
            ],
            [
                'name' => 'Salud',
                'slug' => 'salud',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ]);
    }
}
