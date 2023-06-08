<?php

namespace Modules\Idocs\Events\Handlers;

use Illuminate\Contracts\Mail\Mailer;
use Modules\Idocs\Entities\DocumentUser;
use Modules\Idocs\Events\DocumentWasCreated;
use Modules\Idocs\Emails\Sendmail;
use Modules\Idocs\Events\DocumentWasDownloaded;
use Modules\Setting\Contracts\Setting;
use Illuminate\Support\Arr;

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
    
         foreach ($users as $userId){
           $userDocument = DocumentUser::where("document_id", $document->id)->where("user_id",$userId)->first();
           
           if(!isset($userDocument->id)){
             DocumentUser::create([
               "document_id" => $document->id,
               "user_id" => $userId,
               "key" => null,
             ]);
           }
         }
          
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            return $e;
        }
    }
}