<?php

namespace Modules\Icomments\Entities;

use Modules\Core\Icrud\Entities\CrudModel;
use Modules\Media\Support\Traits\MediaRelation;
use Stancl\Tenancy\Database\Concerns\BelongsToTenant;

class Comment extends CrudModel
{
    use MediaRelation, BelongsToTenant;

    protected $table = 'icomments__comments';

    public $transformer = 'Modules\Icomments\Transformers\CommentTransformer';

    public $repository = 'Modules\Icomments\Repositories\CommentRepository';

    public $requestValidation = [
        'create' => 'Modules\Icomments\Http\Requests\CreateCommentRequest',
        'update' => 'Modules\Icomments\Http\Requests\UpdateCommentRequest',
    ];

    protected $fillable = [
        'comment',
        'approved',
        'internal',
        'commentable_type',
        'commentable_id',
        'guest_name',
        'guest_email',
        'user_id',
        'options',
    ];

    //protected $with = ['commenter', 'commentable'];
    protected $casts = [
        'approved' => 'boolean',
        'options' => 'array',
    ];

    protected $fakeColumns = ['options'];

    public function commenter()
    {
        return $this->morphTo();
    }

    /**
     * The model that was commented upon.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Returns the comment to which this comment belongs to.
     */
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function user()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User");
    }

    public function userProfile()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'user_id');
    }
}
