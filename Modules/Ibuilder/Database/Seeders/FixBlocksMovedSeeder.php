<?php

namespace Modules\Ibuilder\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Modules\Ibuilder\Entities\Block;

class FixBlocksMovedSeeder extends Seeder
{
    public function run()
    {
        Model::unguard();
        //GEt all blocks
        $blocks = Block::get();
        //Validate and fix the component systemName
        foreach ($blocks as $block) {
            if (($block->component['systemName'] ?? '') == 'isite::block-custom') {
                $block->update([
                    'component' => [
                        'nameSpace' => "Modules\Ibuilder\View\Components\BlockCustom",
                        'systemName' => 'ibuilder::block-custom',
                    ],
                ]);
            }
        }
    }
}
