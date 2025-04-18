<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now();

        PaymentMethod::insert([
            [
                'id' => 1,
                'name' => 'Efectivo',
                'description' => 'Pago en efectivo',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ]);
    }
}
