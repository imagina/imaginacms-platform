<?php

namespace Modules\Iwhmcs\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SetGroupToClients implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $logTitle;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->logTitle = '[IWHMCS]::JOB SetGroupToClients';
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            //Get clients without group
            $clientsWithOutGroup = \DB::connection('whmcs')->table('tblclients')->where('groupid', 0)->get();

            //Assign group to client
            foreach ($clientsWithOutGroup as $index => $client) {
                //Count client hosting
                $hostings = \DB::connection('whmcs')->table('tblhosting')->where('userid', $client->id)->count();
                $domains = \DB::connection('whmcs')->table('tbldomains')->where('userid', $client->id)->count();
                $hasNit = preg_match('(^[0-9]{9}-[0-9]{1})', $client->tax_id);
                $groupId = 8; //cliente empresa

                //Define groupId
                if (($hostings <= 10) && ($domains <= 10)) {
                    $groupId = $hasNit ? 8 /*Cliente empresa*/ : 7; //Persona natural
                } else {
                    $groupId = $hasNit ? 3 /*Agencia*/ : 6; //freelance
                }

                //Set group id to client
                $clientUpdated = \DB::connection('whmcs')->table('tblclients')->where('id', $client->id)->update(['groupid' => $groupId]);

                //Log
                \Log::info("{$this->logTitle} ({$index}/{$clientsWithOutGroup->count()})");
            }
        } catch (\Exception $e) {
            \Log::info("{$this->logTitle} failed ".json_encode($e->getMessage()));
        }
    }
}
