<?php

namespace Modules\Iblog\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Iblog\Entities\CategoryTranslation;

class SlugCheckerTableSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        $rolesId = [];
        $categories = CategoryTranslation::all();
        $sameCategories = [];
        //Create Roles
        foreach ($categories as $categoryLeft) {
            $founded = false;
            foreach ($categories as $categoryRight) {
                if ($categoryLeft->category_id != $categoryRight->category_id && $categoryLeft->slug == $categoryRight->slug) {
                    foreach ($sameCategories as $sameCategory) {
                        if (empty(array_diff($sameCategory, [$categoryLeft->category_id, $categoryRight->category_id]))) {
                            $founded = true;
                        }
                    }

                    if (! $founded) {
                        $this->command->alert("Iblog::The Category: $categoryLeft->category_id has the same slug of the Category: $categoryRight->category_id");
                        array_push($sameCategories, [$categoryLeft->category_id, $categoryRight->category_id]);
                    }
                }
            }
        }
    }
}
