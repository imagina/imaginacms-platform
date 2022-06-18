<?php

namespace Modules\Isite\Console;

use Illuminate\Console\Command;
use Spatie\Sitemap\SitemapGenerator;

class GenerateSitemapCommand extends Command
{

  protected $signature = 'sitemap:generate';
  protected $description = 'Generate the sitemap.';

  public function handle()
  {
    // modify this to your own needs
    SitemapGenerator::create(config('app.url'))
      ->writeToFile(public_path('sitemap.xml'));
  }
}