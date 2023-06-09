<?php

namespace Modules\Iblog\Database\Seeders;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MoveStatusToPostsTranslationsTableSeeder extends Seeder
{
    public function run()
    {
        $seedUniquesUse = DB::table('isite__seeds')->where('name', 'MoveStatusToPostsTranslationsTableSeeder')->first();
        if (empty($seedUniquesUse)) {
            $posts = DB::table('iblog__posts')->get();

            $availableLocales = json_decode(setting('core::locales'));
            foreach ($posts as $post) {
                foreach ($availableLocales as $locale) {
                    DB::table('iblog__post_translations')->where('post_id', $post->id)->where('locale', $locale)->
                    update(['status' => $post->status]);
                }
            }
            DB::table('isite__seeds')->insert(['name' => 'MoveStatusToPostsTranslationsTableSeeder']);
            Schema::table('iblog__posts', function (Blueprint $table) {
                $table->dropColumn('status');
            });
        }
    }
}
