<?php

namespace Modules\User\Entities;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Modules\User\Entities\Sentinel\User;

class UserToken extends Model
{
    protected $table = 'user_tokens';

    protected $fillable = ['user_id', 'access_token'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
