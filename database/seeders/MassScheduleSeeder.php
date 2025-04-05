<?php

namespace Database\Seeders;

use App\Models\MassSchedule;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MassScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $date = Carbon::now();

        $schedules = [
            ['day_of_week' => 1, 'start_time' => '07:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 1, 'start_time' => '08:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 1, 'start_time' => '10:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 1, 'start_time' => '17:30', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 1, 'start_time' => '19:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 2, 'start_time' => '07:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 2, 'start_time' => '19:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 3, 'start_time' => '07:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 3, 'start_time' => '19:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 4, 'start_time' => '07:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 4, 'start_time' => '19:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 5, 'start_time' => '07:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 5, 'start_time' => '19:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 6, 'start_time' => '07:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 6, 'start_time' => '17:30', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 6, 'start_time' => '19:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 0, 'start_time' => '06:30', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 0, 'start_time' => '08:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 0, 'start_time' => '10:00', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 0, 'start_time' => '17:30', 'created_at' => $date, 'updated_at' => $date],
            ['day_of_week' => 0, 'start_time' => '19:00', 'created_at' => $date, 'updated_at' => $date],
        ];

        MassSchedule::insert($schedules);
    }
}
