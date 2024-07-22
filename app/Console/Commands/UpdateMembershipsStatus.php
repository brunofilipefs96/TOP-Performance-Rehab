<?php

namespace App\Console\Commands;

use App\Models\Insurance;
use App\Models\Membership;
use App\Models\Notification;
use App\Models\NotificationType;
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

        $memberships = Membership::where('end_date', '<', $today)
            ->where('status_id', 2) // 'active' status ID
            ->get();

        $membershipExpiredType = NotificationType::where('name', 'Matrícula Expirada')->firstOrFail();
        $insuranceExpiredType = NotificationType::where('name', 'Seguro Expirado')->firstOrFail();

        foreach ($memberships as $membership) {

            $insurance = $membership->insurance;

            if (($insurance && $insurance->end_date < $today) && ($membership && $membership->end_date < $today)) {
                // Ambos expirados
                $membership->status_id = 11; // 'inactive' status ID
                $insurance->status_id = 11; // 'inactive' status ID
                $membership->save();
                $insurance->save();

                $this->createNotification($membership->user, $membershipExpiredType, 'A sua matrícula expirou.', 'memberships/' . $membership->id);
                $this->createNotification($membership->user, $insuranceExpiredType, 'O seu seguro expirou.', 'insurances/' . $insurance->id);
            } elseif ($insurance && $insurance->end_date < $today) {
                if ($membership && $membership->end_date < $today) {
                    $membership->status_id = 11; // 'inactive' status ID
                    $insurance->status_id = 11; // 'inactive' status ID
                    $membership->save();
                    $insurance->save();

                    $this->createNotification($membership->user, $membershipExpiredType, 'A sua matrícula expirou.', 'memberships/' . $membership->id);
                    $this->createNotification($membership->user, $insuranceExpiredType, 'O seu seguro expirou.', 'insurances/' . $insurance->id);
                } else {
                    // Membership ativa mas seguro expirado
                    $insurance->status_id = 11; // 'inactive' status ID
                    $membership->status_id = 12; // 'awaiting_insurance' status ID
                    $membership->save();
                    $insurance->save();

                    $this->createNotification($membership->user, $insuranceExpiredType, 'O seu seguro expirou.', 'insurances/' . $insurance->id);
                }
            } elseif ($membership && $membership->end_date < $today) {
                if ($insurance && $insurance->end_date < $today) {
                    $membership->status_id = 11; // 'inactive' status ID
                    $insurance->status_id = 11; // 'inactive' status ID
                    $membership->save();
                    $insurance->save();

                    $this->createNotification($membership->user, $membershipExpiredType, 'A sua matrícula expirou.', 'memberships/' . $membership->id);
                    $this->createNotification($membership->user, $insuranceExpiredType, 'O seu seguro expirou.', 'insurances/' . $insurance->id);
                } else {
                    // Membership expirada mas seguro ainda ativo
                    $membership->status_id = 11; // 'inactive' status ID
                    $insurance->status_id = 13; // 'awaiting_membership' status ID
                    $membership->save();
                    $insurance->save();

                    $this->createNotification($membership->user, $membershipExpiredType, 'A sua matrícula expirou.', 'memberships/' . $membership->id);
                }
            }
        }

        $this->info('Memberships and insurances status updated successfully.');
    }

    protected function createNotification($user, $notificationType, $message, $url)
    {
        $notification = Notification::create([
            'notification_type_id' => $notificationType->id,
            'message' => $message,
            'url' => $url,
        ]);

        $user->notifications()->attach($notification->id);
    }
}
