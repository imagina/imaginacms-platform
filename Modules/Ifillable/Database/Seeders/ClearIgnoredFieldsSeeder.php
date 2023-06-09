<?php

namespace Modules\Ifillable\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
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
