<?php

namespace Modules\Iforms\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Isite\Traits\RevisionableTrait;
use Modules\Media\Support\Traits\MediaRelation;
use Modules\User\Entities\Sentinel\User;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Lead extends Model
{
    use MediaRelation,BelongsToTenant, AuditTrait, RevisionableTrait;

    public $transformer = 'Modules\Iforms\Transformers\LeadTransformer';

    public $entity = 'Modules\Iforms\Entities\Lead';

    public $repository = 'Modules\Iforms\Repositories\LeadRepository';

    protected $table = 'iforms__leads';

    protected $fillable = [
        'form_id',
        'assigned_to_id',
        'values',
    ];

    protected $casts = [
        'values' => 'array',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }
}
