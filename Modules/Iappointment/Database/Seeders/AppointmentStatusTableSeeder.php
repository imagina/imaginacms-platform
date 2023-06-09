<?php

namespace Modules\Iappointment\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Iappointment\Entities\AppointmentStatus;
use Modules\Iappointment\Entities\AppointmentStatusTranslation;

class AppointmentStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();

        $statuses = config('asgard.iappointment.config.appointmentStatuses');

        foreach ($statuses as $status) {
            $statusTrans = $status['title'];

            foreach (['en', 'es'] as $locale) {
                if ($locale == 'en') {
                    $status['title'] = trans($statusTrans, [], $locale);
                    $statusCreated = AppointmentStatusTranslation::where('title', $status['title'])->where('locale', $locale)->first();
                    if (! isset($statusCreated->id)) {
                        $appointmentStatus = AppointmentStatus::where('id', $status['id'])->first();
                        if (! $appointmentStatus) {
                            $appointmentStatus = AppointmentStatus::create($status);
                        }
                    } else {
                        $appointmentStatus = AppointmentStatus::where('id', $status['id'])->first();
                        if (! $appointmentStatus) {
                            $appointmentStatus = AppointmentStatus::create($status);
                        }
                    }
                } else {
                    $title = trans($statusTrans, [], $locale);
                    $statusCreated = AppointmentStatusTranslation::where('title', $title)->where('locale', $locale)->first();
                    if (! isset($statusCreated->id)) {
                        $appointmentStatus = AppointmentStatus::where('id', $status['id'])->first();
                        if (! $appointmentStatus) {
                            $appointmentStatus = AppointmentStatus::create($status);
                        }
                        $appointmentStatus->translateOrNew($locale)->title = $title;
                        $appointmentStatus->save();
                    } else {
                        $appointmentStatus = AppointmentStatus::where('id', $status['id'])->first();
                        if (! $appointmentStatus) {
                            $appointmentStatus = AppointmentStatus::create($status);
                        }
                    }
                }
            }//End Foreach
        }//End Foreach
    }
}
