<?php

namespace Modules\Media\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DeleteSvgOfImageTypes extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    $settingRepository = app('Modules\Setting\Repositories\SettingRepository');
    $allowedImageTypes = json_decode(setting('media::allowedImageTypes'));
    $allowedFileTypes = json_decode(setting('media::allowedFileTypes'));
    if (in_array("svg", $allowedImageTypes)) {
      $allowedImageTypesWithoutSvg = json_encode(array_diff($allowedImageTypes, ['svg']));
      $settingUpdate = [
        'media::allowedImageTypes' => $allowedImageTypesWithoutSvg,
      ];
      $settingRepository->createOrUpdate($settingUpdate);
    }
    if (!in_array("svg", $allowedFileTypes)) {
      $allowedFileTypes[] = "svg";
      $allowedFileTypesWithSvg = json_encode($allowedFileTypes);
      $settingUpdate = [
        'media::allowedFileTypes' => $allowedFileTypesWithSvg,
      ];
      $settingRepository->createOrUpdate($settingUpdate);
    }
  }
}
