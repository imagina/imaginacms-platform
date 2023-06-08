<?php

namespace Modules\Iblog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Iblog\Entities\Post;
use Modules\Isite\Entities\Layout;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;


class MoveStatusToCategoryTranslationsTable extends Seeder
{

  public function run()
  {
    $seedUniquesUse = DB::table('isite__seeds')->where("name", 'MoveStatusToCategoryTranslationsTable')->first();
    if (empty($seedUniquesUse)) {
      $categories = DB::table('iblog__categories')->get();

      $availableLocales = json_decode(setting('core::locales'));
      foreach ($categories as $category) {
        foreach ($availableLocales as $locale) {
          DB::table('iblog__category_translations')->where('category_id', $category->id)->where('locale', $locale)->
          update(['status' => $category->status]);
        }
      }
      DB::table('isite__seeds')->insert(['name' => 'MoveStatusToCategoryTranslationsTable']);
      Schema::table('iblog__categories', function (Blueprint $table) {
        $table->dropColumn('status');
      });
    }
  }
}
