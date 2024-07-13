<?php

namespace App\Console\Commands;

use App\Models\Insurance;
use App\Models\Membership;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateMembershipsStatus extends Command
{
    protected $signature = 'memberships:update-status';

    protected $description = 'Update the status of memberships and insurances with end_date less than the current date';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $today = Carbon::today();

        // Atualiza memberships com end_date menor que hoje e status 'active'
        $memberships = Membership::where('end_date', '<', $today)
            ->where('status_id', 2) // 'active' status ID
            ->get();

        foreach ($memberships as $membership) {

            $insurance = $membership->insurance;

            if (($insurance && $insurance->end_date < $today) && ($membership && $membership->end_date < $today)) {
                // Caso ambos expirados
                $membership->status_id = 11; // 'inactive' status ID
                $insurance->status_id = 11; // 'inactive' status ID
                $membership->save();
                $insurance->save();
            } elseif ($insurance && $insurance->end_date < $today) {
                if($membership && $membership->end_date < $today){
                    $membership->status_id = 11; // 'inactive' status ID
                    $insurance->status_id = 11; // 'inactive' status ID
                    $membership->save();
                    $insurance->save();
                } else {
                    // Membership ativa mas insurance expirado
                    $insurance->status_id = 11; // 'inactive' status ID
                    $membership->status_id = 12; // 'awaiting_insurance' status ID
                    $membership->save();
                    $insurance->save();
                }

            } elseif ($membership && $membership->end_date < $today) {
                if($insurance && $insurance->end_date < $today) {
                    $membership->status_id = 11; // 'inactive' status ID
                    $insurance->status_id = 11; // 'inactive' status ID
                    $membership->save();
                    $insurance->save();
                } else {
                    // Membership expirada mas insurance ainda ativo
                    $membership->status_id = 11; // 'inactive' status ID
                    $insurance->status_id = 13; // 'awaiting_membership' status ID
                    $membership->save();
                    $insurance->save();
                }
            }
        }

        $this->info('Memberships and insurances status updated successfully.');
    }
}
