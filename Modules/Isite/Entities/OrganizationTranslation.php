<?php

namespace Modules\Isite\Entities;

use Illuminate\Database\Eloquent\Model;

class OrganizationTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = [
      'title',
      'slug',
      'description',
      'meta_title',
      'meta_description',
      'translatable_options'
    ];
    protected $table = 'isite__organization_translations';
}
