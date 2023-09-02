<?php

namespace Modules\Notification\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Notification\Entities\NotificationType;

class NotificationTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();

        DB::table('notification__notification_types')->truncate();
        $notificationTypes = config('asgard.notification.config.notificationTypes');

        foreach ($notificationTypes as $type) {
            NotificationType::create($type);
        }
    }
}
