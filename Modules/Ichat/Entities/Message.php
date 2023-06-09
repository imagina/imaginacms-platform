<?php

namespace Modules\Ichat\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Support\Traits\AuditTrait;
use Modules\Media\Support\Traits\MediaRelation;

class Message extends Model
{
    protected $table = 'ichat__messages';

    use MediaRelation, AuditTrait;

    protected $fillable = [
        'type',
        'body',
        'attached',
        'conversation_id',
        'user_id',
        'reply_to_id',
        'created_at',
        'options',
    ];

    protected $casts = [
        'options' => 'array',
    ];

    public function conversation()
    {
        return $this->belongsTo('Modules\Ichat\Entities\Conversation');
    }

    public function user()
    {
        $driver = config('asgard.user.config.driver');

        return $this->belongsTo("Modules\\User\\Entities\\{$driver}\\User", 'user_id');
    }

    public function replyTo()
    {
        return $this->hasOne(Message::class, 'id', 'reply_to_id');
    }

    /**
     * @return mixed
     */
    public function getAttachmentAttribute()
    {
        if (! empty($this->attached)) {
            $thumbnail = $this->files()->where('zone', 'attachment')->first();

            return [
                'mimetype' => $thumbnail->mimetype ?? '',
                'path' => \URL::route('ichat.message.attachment', ['conversationId' => $this->conversation_id, 'messageId' => $this->id, 'attachmentId' => $this->attached]),
                'extension' => $thumbnail->extension ?? '',
                'filename' => $thumbnail->filename ?? '',
                'filesize' => $thumbnail->filesize ?? '',
            ];
        } else {
            return null;
        }
    }
}
