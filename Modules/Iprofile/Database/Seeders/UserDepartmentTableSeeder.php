<?php

namespace Modules\Iprofile\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Iprofile\Entities\UserDepartment;


class UserDepartmentTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    
    $uerDepartment = UserDepartment::where('user_id', 1)->where('department_id', 1)->first();
    
    if(!isset($uerDepartment->id))
      UserDepartment::create([
        'user_id' => 1,
        'department_id' => 1
      ]);
  }
}
