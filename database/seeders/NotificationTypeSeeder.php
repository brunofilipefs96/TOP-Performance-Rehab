<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notificationTypes = [
            ['name' => 'membershipAproved'],
            ['name' => 'membershipDenied'],
            ['name' => 'membershipFreezed'],
            ['name' => 'membershipExpired'],
            ['name' => 'insuranceAproved'],
            ['name' => 'insuranceDenied'],
            ['name' => 'insuranceFreezed'],
            ['name' => 'insuranceExpired'],
            ['name' => 'renewAproved'],
            ['name' => 'renewDenied'],
        ];

        DB::table('notification_types')->insert($notificationTypes);
    }
}
