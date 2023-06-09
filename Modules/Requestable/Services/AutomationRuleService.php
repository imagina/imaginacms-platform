<?php

namespace Modules\Requestable\Services;

use Modules\Requestable\Jobs\ProcessNotification;

class AutomationRuleService
{
    public function __construct()
    {
    }

    /*
    * check rules and dispatch job
    */
    public function checkRulesAndDispatchJob($requestable)
    {
        \Log::info('Requestable: Services|AutomationRule|checkRulesAndDispatchJob|Status: '.$requestable->status->title.' - ID:'.$requestable->status->id);

        //Check Status relation exist and status has an Automation Rules
        if (isset($requestable->status) && isset($requestable->status->automationRules) && count($requestable->status->automationRules) > 0) {
            \Log::info('Requestable: Services|AutomationRule|checkRulesAndDispatchJob|Check Rules');

            $automationRules = $requestable->status->automationRules;
            foreach ($automationRules as $key => $rule) {
                if ($rule->status == 1) {
                    $delay = $this->getDelay($rule, $requestable);
                    if (! is_null($delay)) {
                        //\Log::info('Requestable: Handler|CheckStatusRequestable|Create Job to Rule Id:'.$rule->id);
                        ProcessNotification::dispatch($rule, $requestable, $requestable->lastStatusHistoryId())->delay($delay);
                    }
                }
            }
        }
    }

    /*
    * Get Delay to the job
    */
    public function getDelay(object $rule, object $requestable)
    {
        //\Log::info('Requestable: Handler|CheckStatusRequestable|run_type: '.$rule->run_type." ************");
        //\Log::info('Requestable: Handler|CheckStatusRequestable|run_config: '.json_encode($rule->run_config));

        $delay = null;

        // el run_config será "null", y la regla se ejecutara de inmediato.
        if ($rule->run_type == 'currentTime') {
            $delay = now();
        }
        // el run_config solo vendrá el atributo "date" con el campo del request donde obtener la fecha Ejemplo: (date: created_at)
        if ($rule->run_type == 'exactTime') {
            if (isset($rule->run_config) && isset($rule->run_config->date)) {
                $dateField = $rule->run_config->date;
                $delay = $requestable->{$dateField};
            }
        }
        // el run_config vendra el value y el type ejemplo: {value:5,type:days, date: un campo X de la misma request
        if ($rule->run_type == 'inAfter') {
            if (isset($rule->run_config) && isset($rule->run_config->date)) {
                $dateField = $rule->run_config->date;
                $date = $requestable->{$dateField};

                $value = $rule->run_config->value;

                if ($rule->run_config->type == 'days') {
                    $delay = $date->addDays($value);
                }

                if ($rule->run_config->type == 'hours') {
                    $delay = $date->addHours($value);
                }

                if ($rule->run_config->type == 'minutes') {
                    $delay = $date->addMinutes($value);
                }
            }
        }
        // Si el run_type es "inBefore", pasa lo mismo que con inAfter pero se aplica antes las fecha de XXXX
        if ($rule->run_type == 'inBefore') {
            if (isset($rule->run_config) && isset($rule->run_config->date)) {
                $dateField = $rule->run_config->date;
                $date = $requestable->{$dateField};

                $value = $rule->run_config->value;

                if ($rule->run_config->type == 'days') {
                    $delay = $date->subDays($value);
                }

                if ($rule->run_config->type == 'hours') {
                    $delay = $date->subHours($value);
                }

                if ($rule->run_config->type == 'minutes') {
                    $delay = $date->subMinutes($value);
                }
            }
        }

        //\Log::info('Requestable: Handler|CheckStatusRequestable|Delay: '.json_encode($delay));

        return $delay;
    }
}
