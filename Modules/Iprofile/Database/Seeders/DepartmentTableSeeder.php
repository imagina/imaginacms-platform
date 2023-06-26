<?php

namespace Modules\Iprofile\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Iprofile\Entities\Department;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();

        $department = Department::where('title', 'Users')->where('parent_id', 0)->first();

        if (! isset($department->id)) {
            Department::create([
                'title' => 'Users',
                'parent_id' => 0,
            ]);
        }
    }
}
