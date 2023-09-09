<?php

namespace Modules\Media\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Media\Entities\File;
use Modules\Media\Image\Imagy;

class ValidateHasThumbnailsTableSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    Model::unguard();
    $imagy = app(Imagy::class);
    $imageExtensions = json_decode(setting('media::allowedImageTypes', null, config("asgard.media.config.allowedImageTypes")));
    $files = File::where('has_thumbnails', false)->whereIn('extension', $imageExtensions)->get();
    //Validate if has thumbnails
    foreach ($files as $file) {
      $thubmbnail = $imagy->getThumbnail($file, 'smallThumb');
      $thubmbnailPath = preg_replace('/^https?:\/\/.*?\//', '', $thubmbnail);
      if ($imagy->fileExists($thubmbnailPath, $file->disk)) {
        File::where('id', $file->id)->update(['has_thumbnails' => true]);
      }
    }
  }
}
