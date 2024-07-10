<?php

namespace Database\Seeders;

use App\Models\GymClosure;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GymClosureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $year = date('Y');
        for ($month = 1; $month <= 12; $month++) {
            for ($day = 1; $day <= 31; $day++) {
                if (checkdate($month, $day, $year)) {
                    $date = "$year-$month-$day";
                    if (date('N', strtotime($date)) == 7) {
                        GymClosure::updateOrCreate(['closure_date' => $date]);
                    }
                }
            }
        }
    }
}
