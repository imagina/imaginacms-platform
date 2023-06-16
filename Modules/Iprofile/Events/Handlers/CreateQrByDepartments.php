<?php

namespace Modules\Iprofile\Events\Handlers;

class CreateQrByDepartments
{
    public $qrService;

    public function __construct()
    {
    }

    public function handle($event)
    {
        if (is_module_enabled('Qreable')) {
            $this->qrService = app("Modules\Qreable\Services\QrService");
            try {
                $user = $event->user;
                $departments = $user->departments;
                foreach ($departments as $department) {
                    if ($department->is_internal) {
                        $this->qrService->addQr($user, '/account/vcard/'.$user->id, 'vcard');
                    }
                }
            } catch (\Exception $e) {
                \Log::error('Iprofile: Events|Handlers|CreateQrByDepartments|Message: '.$e->getMessage().' | FILE: '.$e->getFile().' | LINE: '.$e->getLine());
            }
        }
    }
}
