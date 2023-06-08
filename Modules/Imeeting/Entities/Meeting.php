<?php

namespace Modules\Imeeting\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Icrud\Entities\CrudModel;

class Meeting extends CrudModel
{
   
    public $transformer = 'Modules\Imeeting\Transformers\MeetingTransformer';
    public $requestValidation = [
        'create' => 'Modules\Imeeting\Http\Requests\CreateMeetingRequest',
        'update' => 'Modules\Imeeting\Http\Requests\UpdateMeetingRequest',
    ];

    protected $table = 'imeeting__meetings';

    protected $fillable = [
        'provider_name',
        'provider_meeting_id',
        'star_url',
        'join_url',
        'password',
        'entity_id',
        'entity_type'
    ];

    protected $casts = [
        'options' => 'array'
    ];

    public function getOptionsAttribute($value)
    {
        return json_decode($value);
    }

    public function setOptionsAttribute($value)
    {
        $this->attributes['options'] = json_encode($value);
    }

    
    public function meetingable()
    {
        return $this->morphTo();
    }
   


}
