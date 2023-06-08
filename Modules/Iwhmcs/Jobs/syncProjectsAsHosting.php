<?php

namespace Modules\Iwhmcs\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class syncProjectsAsHosting implements ShouldQueue
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
    $this->logTitle = '[IWHMCS]::JOB syncProjectsAsHosting';
  }

  /**
   * Execute the job.
   *
   * @return void
   */
  public function handle()
  {
    try {
      //Projects regex
      $projectsRegex = [
        ['value' => 'Negocios II', 'packageId' => 85],
        ['value' => 'Negocios I', 'packageId' => 84],
        ['value' => 'Emprendedor II', 'packageId' => 82],
        ['value' => 'Emprendedor I', 'packageId' => 81],
        ['value' => 'Corporativo III', 'packageId' => 160],
        ['value' => 'Corporativo II', 'packageId' => 87],
        ['value' => 'Corporativo I', 'packageId' => 86],
        ['value' => 'Tienda Emprededor', 'packageId' => 330],//Emprendedores
        ['value' => 'Tienda Corporativo', 'packageId' => 332],//Corporativo
        ['value' => 'Tienda', 'packageId' => 331],//Negocios
        ['value' => 'P.Básico', 'packageId' => 333],//Plan Basico (Diseño)
        ['value' => 'P.Medio', 'packageId' => 334],//Plan Medio (Diseño)
        ['value' => 'P.Pro', 'packageId' => 334],//Plan Pro (Diseño)
        ['value' => 'Tienda', 'packageId' => 331],//Negocios
        ['value' => 'web', 'packageId' => 84],// Plan negocios I

        //Comunity Manager
        ['value' => 'SEO', 'packageId' => 79],//Plan pyme SEO
        ['value' => 'PR.SEO', 'packageId' => 79],//Plan pyme SEO
        ['value' => 'Community', 'packageId' => 75],//Plan Emprendedor
        ['value' => 'Google', 'packageId' => 76],//Plan Negocios
        ['value' => 'Facebook', 'packageId' => 76],//Plan Negocios
        ['value' => 'Adwords', 'packageId' => 76],//Plan Negocios

        //Diseño
        ['value' => 'Diseño', 'packageId' => 334],//Plan Medio (Identidad Visual)
        ['value' => 'Rediseño', 'packageId' => 334],//Plan Medio (Identidad Visual)
        ['value' => 'Logo', 'packageId' => 334],//Plan Medio (Identidad Visual)
        ['value' => 'Imagen corporativa', 'packageId' => 334],//Plan Medio (Identidad Visual)
        ['value' => 'Identidad Visual', 'packageId' => 334],//Plan Medio (Identidad Visual)
        ['value' => 'Brochure', 'packageId' => 334],//Plan Medio (Identidad Visual)

        //Administración WEB
        ['value' => 'Modificaciones', 'packageId' => 336],//Admin WEB
        ['value' => 'cambios', 'packageId' => 336],//Admin WEB
        ['value' => 'Actualizacion', 'packageId' => 336],//Admin WEB
        ['value' => 'Landing', 'packageId' => 336],//Admin WEB
        ['value' => 'Layout', 'packageId' => 336],//Admin WEB
        ['value' => 'IM', 'packageId' => 336],//Admin WEB
        ['value' => 'CM', 'packageId' => 336],//Admin WEB
        ['value' => 'App', 'packageId' => 336],//Admin WEB
        ['value' => 'banner', 'packageId' => 336],//Admin WEB
        ['value' => 'modulo', 'packageId' => 336],//Admin WEB
        ['value' => 'Administracion', 'packageId' => 336],//Admin WEB

        //Default
        ['value' => false, 'packageId' => 84],// Plan negocios I
      ];

      //Search project by regex
      foreach ($projectsRegex as $index => $regex) {
        //Search project with same name
        $queryProjects = \DB::connection('whmcs')->table('mod_project')->whereNull('service_id');

        //limit by regex
        if ($regex['value']) $queryProjects->where('title', 'like', "%{$regex['value']}%");

        //Run query
        $projects = $queryProjects->get();

        //Define products data to create
        foreach ($projects as $index => $project) {
          //Insert product
          $hostingId = \DB::connection('whmcs')->table('tblhosting')->insertGetId([
            'userid' => $project->userid,
            'packageid' => $regex['packageId'],
            'domain' => $project->title,
            'paymentmethod' => 'banktransfer',
            'billingcycle' => 'One Time',
            'domainstatus' => 'Completed',
            'username' => 'msolano',
            'nextduedate' => $project->duedate,
            'completed_date' => $project->duedate,
            'created_at' => $project->created . ' 00:00:00',
            'regdate' => $project->created,
            'updated_at' => $project->lastmodified,
            'lastupdate' => $project->lastmodified,
          ]);
          //set service id to project
          \DB::connection('whmcs')->table('mod_project')->where('id', $project->id)
            ->update(['service_id' => $hostingId]);
          //Log
          \Log::info("{$this->logTitle} ({$index}/{$projects->count()}");
        }
      }
    } catch (\Exception $e) {
      dd($e->getMessage());
      \Log::info("{$this->logTitle} failed" . json_encode($e->getMessage()));
    }
  }
}
