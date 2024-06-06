<?php

namespace Modules\Isite\Entities;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
  private $siteSettings;

  
  public function __construct()
  {
    
    $this->siteSettings = setting('isite::siteSettings');

    
  }
  
  public function getData()
  {
    return (object) [
      'siteSettings' => json_decode($this->siteSettings)
    ];
  }
  
}
