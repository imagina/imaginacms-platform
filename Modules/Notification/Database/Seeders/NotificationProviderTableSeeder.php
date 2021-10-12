<?php

namespace Modules\Notification\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Notification\Entities\Provider;

class NotificationProviderTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();

      $emailProvider = DB::table('notification__providers')->where("system_name","email")->first();

      if(!isset($emailProvider->id)){
       Provider::create([
         "name" => "Email",
         "system_name" => "email",
         "status" => 1,
         "default" => 1,
         "type" => "email",
         "options" => ["fromName" => null,"fromEmail" => null,"saveInDatabase" => 1]
       ]);
      
      }
      
  }
}
