<?php

namespace Modules\Requestable\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class RequestableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        Model::unguard();

        $this->call(RequestableModuleTableSeeder::class);

        $requestableRepository = app("Modules\Requestable\Repositories\RequestableRepository");
        $categoryRepository = app("Modules\Requestable\Repositories\CategoryRepository");
        $statusRepository = app("Modules\Requestable\Repositories\StatusRepository");
        $locale = \LaravelLocalization::setLocale() ?: \App::getLocale();
        $params = [
            'filter' => [
                'field' => 'type',
            ],
            'include' => [],
            'fields' => [],
        ];
        $requestableConfig = $requestableRepository->moduleConfigs();

        $requestableService = app("Modules\Requestable\Services\RequestableService");

        foreach ($requestableConfig as $config) {
            $requestableService->createFromConfig($config);
        }
    }
}
