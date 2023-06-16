<?php

if (! function_exists('auctionsGetEmailTo')) {
    function auctionsGetEmailTo($model)
    {
        $providers = $model->department->users;

        //Set emailTo
        $emails[] = $model->user->email;
        $providersEmails = $providers->pluck('email')->toArray();

        $emailTo = array_merge($emails, $providersEmails);
        //\Log::info("emailTo ".json_encode($emailTo));

        return $emailTo;
    }
}

if (! function_exists('auctionsGetBroadcastTo')) {
    function auctionsGetBroadcastTo($model)
    {
        $providers = $model->department->users;

        //Set BroadcastTo
        $broadcastTo = $providers->pluck('id')->toArray();
        array_push($broadcastTo, $model->user->id);
        //\Log::info("broadcastTo ".json_encode($broadcastTo));

        return $broadcastTo;
    }
}
