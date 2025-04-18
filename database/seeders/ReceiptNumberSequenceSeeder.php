<?php

namespace Database\Seeders;

use App\Models\ReceiptNumberSequence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReceiptNumberSequenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ReceiptNumberSequence
            ::create([
                'receipt_type_id' => 1,
                'prefix' => 'CP-',
                'last_receipt_number' => 0,
            ]);
    }
}
