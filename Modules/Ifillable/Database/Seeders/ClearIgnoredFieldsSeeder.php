<?php

namespace Modules\Ifillable\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Ifillable\Entities\Field;


class ClearIgnoredFieldsSeeder extends Seeder
{

  public function run()
  {
    Model::unguard();
    $ignoredFields = getIgnoredFields();
    Field::whereIn('name', $ignoredFields)->forceDelete();
  }
}
