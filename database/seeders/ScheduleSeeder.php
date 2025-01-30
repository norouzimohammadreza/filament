<?php

namespace Database\Seeders;

use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'TaskRunEveryMinutes',
                'frequency' => 'everySecond',
            ],
            [
                'name' => 'TaskRunHourly',
                'frequency' => 'hourly'
            ],
            [
                'name' => 'TaskRunHourlyWithParam',
                'frequency' => 'hourlyAt',
                'params' => '17'
            ],
            [
                'name' => 'TaskRunTwiceDaily',
                'frequency' => 'twiceDaily',
                'params' => '1,13'
            ]
        ];

        foreach ($data as $key => $value) {
            Schedule::create($value);
        }
    }
}
