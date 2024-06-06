<?php

namespace Modules\Notification\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Notification\Entities\NotificationType;
use Illuminate\Support\Facades\DB;

class NotificationTypeTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
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
