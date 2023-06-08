<?php
namespace Modules\Qreable\Traits;

use Modules\Qreable\Entities\Qr;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

trait QreableTrait
{
  /**
   * {@inheritdoc}
   */
  protected static $qrsModel = Qr::class;

  /**
   * {@inheritdoc}
   */
  public static function getQrsModel()
  {
    return static::$qrsModel;
  }

  /**
   * {@inheritdoc}
   */
  public static function setQrsModel($model)
  {
    static::$qrsModel = $model;
  }

  /**
   * {@inheritdoc}
   */
  public function qrs()
  {
    return $this->morphToMany(static::$qrsModel, 'qreable', 'qreable__qred', 'qreable_id', 'qr_id');
  }

  /**
   * {@inheritdoc}
   */
  public static function createQrsModel()
  {
    return new static::$qrsModel;
  }

  /**
   * {@inheritdoc}
   */
  public static function allQrs()
  {
    $instance = new static;

    return $instance->createQrsModel()->whereNamespace($instance->getEntityClassName());
  }

  public function setQrs($qrs)
  {
    if (empty($qrs)) {
      $qrs = [];
    }

    // Get the current entity locations
    $entityQrs = $this->qrs->all();

    // Prepare the locations to be added and removed
    $qrsToAdd = array_diff($qrs, $entityQrs);
    $qrsToDel = array_diff($entityQrs, $qrs);

    // Detach the locations
    if (count($qrsToDel) > 0) {
      $this->unqr($qrsToDel);
    }

    // Attach the locations
    if (count($qrsToAdd) > 0) {
      $this->qr($qrsToAdd);
    }

    return true;
  }

  /**
   * {@inheritdoc}
   */
  public function qr($qrs)
  {
    foreach ($qrs as $qr) {
      $this->addQr($qr);
    }

    return true;
  }

  /**
   * {@inheritdoc}
   */
  public function addQr($qrc)
  {
    \Log::info($qrc);
    $code = $this->generateQrCode($qrc);
    $qr = $this->createQrsModel()->where('code', $code)->first();
    if ($qr === null) {
      $qr = new Qr(['code'=>$code]);
    }
    if ($qr->exists === false) {
      $qr->save();
    }

    if ($this->qrs->contains($qr->id) === false) {
      $this->qrs()->attach($qr);
    }
  }

  /**
   * {@inheritdoc}
   */
  public function unqr($qrs = null)
  {
    $qrs = $qrs ?: $this->qrs->pluck('code')->all();

    foreach ($qrs as $qr) {
      $this->removeQr($qr);
    }

    return true;
  }

  /**
   * {@inheritdoc}
   */
  public function removeQr($code)
  {
    $qr = $this->createQrsModel()
      ->where('code', $code)
      ->first();

    if ($qr) {
      $this->qrs()->detach($qr);
    }
  }

  /**
   * {@inheritdoc}
   */
  protected function getEntityClassName()
  {
    if (isset(static::$entityNamespace)) {
      return static::$entityNamespace;
    }

    return $this->qrs()->getMorphClass();
  }

  public function generateQrCode($qreable){
    $qrCode = QrCode::format('png')->size(1024)->color(0,100,177)->generate($qreable);
    return 'data:image/png;base64,'.base64_encode($qrCode);
  }

}
