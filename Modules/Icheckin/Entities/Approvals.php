<?php

namespace Modules\Icheckin\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

class Approvals extends Model
{
    protected $table = 'icheckin__approvals';

    protected $fillable = [
        'user_id',
        'department_id',
        'approved_by',
        'date',
        'period_approved',
    ];

    protected $with = [
        'user',
        'approvedBy',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id')->with('fields');
    }

    public function approvedBy()
    {
        return $this->hasOne(User::class, 'id', 'approved_by')->with('fields');
    }
}
