<?php


namespace Modules\Iforms\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Iforms\Entities\Block;
use Modules\Iforms\Entities\Form;

class BlockTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $forms = Form::all();
        foreach ($forms as $form){
            if($form->blocks()->count() === 0){
                $block = $form->blocks()->create([
                    'title' => trans('iforms::blocks.messages.default_block_title'),
                    'description' => trans('iforms::blocks.messages.default_block_description'),
                    'sort_order' => 0
                ]);
                $fields = $form->fields()->get();
                foreach($fields as $field){
                    $field->block_id = $block->id;
                    $field->save();
                }
            }
        }
    }
}
