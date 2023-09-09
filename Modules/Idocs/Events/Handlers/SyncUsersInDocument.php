<?php

namespace Modules\Idocs\Events\Handlers;

use Illuminate\Support\Arr;
use Modules\Idocs\Entities\DocumentUser;

class SyncUsersInDocument
{
    public function __construct()
    {
    }

    public function handle($event)
    {
        try {
            $document = $event->document;
            $data = $event->data;
            $users = Arr::get($data, 'users', []);

            foreach ($users as $userId) {
                $userDocument = DocumentUser::where('document_id', $document->id)->where('user_id', $userId)->first();

                if (! isset($userDocument->id)) {
                    DocumentUser::create([
                        'document_id' => $document->id,
                        'user_id' => $userId,
                        'key' => null,
                    ]);
                }
            }

    $usersDocument = DocumentUser::where("document_id", $document->id)->get();
    foreach ($usersDocument as $userDocument) {
      if(!in_array($userDocument->user_id, $users)) {
        $userDocument->delete();
      }
    }

        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return $e;
        }
    }
}
