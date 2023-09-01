<?php

namespace Modules\Ifeed\Entities;

use Astrotomic\Translatable\Translatable;
use Modules\Core\Icrud\Entities\CrudModel;

class Feed extends CrudModel
{
    use Translatable;

    protected $table = 'ifeed__feeds';

    public $transformer = 'Modules\Ifeed\Transformers\FeedTransformer';

    public $requestValidation = [
        'create' => 'Modules\Ifeed\Http\Requests\CreateFeedRequest',
        'update' => 'Modules\Ifeed\Http\Requests\UpdateFeedRequest',
    ];

    //Instance external/internal events to dispatch with extraData
    public $dispatchesEventsWithBindings = [
        //eg. ['path' => 'path/module/event', 'extraData' => [/*...optional*/]]
        'created' => [],
        'creating' => [],
        'updated' => [],
        'updating' => [],
        'deleting' => [],
        'deleted' => [],
    ];

    public $translatedAttributes = [];

    protected $fillable = [];
}
