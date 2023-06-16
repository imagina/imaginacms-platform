<?php

namespace Modules\Ichat\Services;

use Modules\Ichat\Repositories\ConversationRepository;

class ConversationService
{
    public function __construct(ConversationRepository $conversation)
    {
        $this->conversation = $conversation;
    }

    public function create($data)
    {
        try {
            $conversation = $this->conversation->create($data);

            return $conversation;
        } catch (\Exception $e) {
        }

        return false;
    }

    public function update($conversationId, $data)
    {
        try {
            $this->conversation->updateBy($conversationId, $data);
        } catch (\Exception $e) {
        }
    }
}
