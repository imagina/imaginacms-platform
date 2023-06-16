<?php

namespace Modules\Idocs\Events\Handlers;

use Modules\Idocs\Entities\DocumentUser;
use Modules\Idocs\Events\DocumentWasDownloaded;

class TrackingDocument
{
    public function __construct()
    {
    }

    public function handle(DocumentWasDownloaded $event)
    {
        try {
            $document = $event->document;
            $key = $event->key;
            $user = \Auth::user();

            //Tracking downloads to private documents
            $query = DocumentUser::where('document_id', $document->id);
            if (isset($user->id)) {
                $query->where('user_id', $user->id);
            } else {
                if ($key) {
                    $query->where('key', $key);
                }
            }

            $documentUser = $query->first();

            if (isset($documentUser->id)) {
                $documentUser->downloaded = $documentUser->downloaded + 1;
                $documentUser->save();
            }

            //Tracking downloads to master document
            $document->downloaded = $document->downloaded + 1;
            $document->save();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());

            return $e;
        }
    }
}
