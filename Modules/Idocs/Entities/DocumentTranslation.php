<?php

namespace Modules\Idocs\Entities;

use Illuminate\Database\Eloquent\Model;

class DocumentTranslation extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'description'];
    protected $table = 'idocs__document_translations';
}
