<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            ['name' => 'pending'],                  //-- 1 Pending
            ['name' => 'active'],                   //-- 2 Active
            ['name' => 'rejected'],                 //-- 3 Rejected
            ['name' => 'frozen'],                   //-- 4 Frozen
            ['name' => 'pending_payment'],          //-- 5 Pending_payment
            ['name' => 'paid'],                     //-- 6 Paid
            ['name' => 'canceled'],                 //-- 7 Canceled
            ['name' => 'delivered'],                //-- 8 Delivered
            ['name' => 'returned'],                 //-- 9 Returned
            ['name' => 'refunded'],                 //-- 10 Refunded
            ['name' => 'inactive'],                 //-- 11 Inactive
            ['name' => 'awaiting_insurance'],       //-- 12 Awaiting_insurance
            ['name' => 'awaiting_membership'],      //-- 13 Awaiting_membership
            ['name' => 'renew_pending'],            //-- 14 Renew_pending
            ['name' => 'pending_renewPayment'],     //-- 15 Pending_renewPayment
            ['name' => 'awaiting_pickup'],          //-- 16 Awaiting_pickup
        ];

        DB::table('statuses')->insert($statuses);
    }
}
