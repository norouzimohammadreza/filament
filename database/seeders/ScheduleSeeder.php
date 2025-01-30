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
                    'cron' => '* * * * *',
                ],
                [
                    'name' => 'TaskRunHourly',
                    'cron' => '0 * * * *',
                ],
                [
                    'name' => 'TaskRunHourlyWithParam',
                    'cron' => '30 * * * *',
                ],
                [
                    'name' => 'TaskRunTwiceDaily',
                    'cron' => '0 7,19 * * *',
                ]
        ];

        foreach ($data as $key => $value) {
            Schedule::create($value);
        }
    }
}
