<?php

namespace Modules\Requestable\Events\Handlers;

class CheckStatusRequestable
{
    private $automationRuleService;

    public function __construct()
    {
        $this->automationRuleService = app("Modules\Requestable\Services\AutomationRuleService");
    }

    /**
     * Init handle
     */
    public function handle($event)
    {
        try {
            //Model
            $requestable = $event->requestable;
            \Log::info('Requestable: Handler|CheckStatusRequestable|ID: '.$requestable->id);

            if (get_class($event) == "Modules\Requestable\Events\RequestableWasUpdated") {
                //\Log::info('Requestable: Handler|CheckStatusRequestable|wasChanged: '.$requestable->wasChanged("status_id"));
                if ($requestable->wasChanged('status_id')) {
                    $this->automationRuleService->checkRulesAndDispatchJob($requestable);
                }
            } else {
                //Created
                $this->automationRuleService->checkRulesAndDispatchJob($requestable);
            }
        } catch (\Exception $e) {
            \Log::error('Requestable: Events|Handler|CheckStatusRequestable|Message: '.$e->getMessage().' | FILE: '.$e->getFile().' | LINE: '.$e->getLine());
        }
    }// If handle
}
