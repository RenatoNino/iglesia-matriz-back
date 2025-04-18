<?php

namespace Database\Seeders;

use App\Models\ReceiptType;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReceiptTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now();

        ReceiptType::insert([
            [
                'id' => 1,
                'name' => 'Comprobante de pago',
                'description' => 'Comprobante de pago',
                'created_at' => $date,
                'updated_at' => $date,
            ],
        ]);
    }
}
