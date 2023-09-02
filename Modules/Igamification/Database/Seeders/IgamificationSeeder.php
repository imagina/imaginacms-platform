<?php

namespace Modules\Igamification\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class IgamificationSeeder extends Seeder
{
    protected $uploadedFiles;

    /**
     * Run the database seeds.
     */
    public function run()
    {
        Model::unguard();
        //Instance the uploaded files
        $this->uploadedFiles = [];
        // Get the modules actives
        $modules = \Module::getByStatus(1);
        //Instance data to seed
        $modulesCategories = [];
        $modulesActivities = [];
        //go throught the modules and search the gamification config
        foreach ($modules as $moduleName => $module) {
            //Publish module
            \Artisan::call('module:publish', ['module' => $module->getLowerName()]);
            // Get gamification by module
            $gamification = config('asgard.'.$module->getLowerName().'.gamification');
            if ($gamification) {
                //Seed categories
                if (isset($gamification['categories']) && is_array($gamification['categories'])) {
                    $modulesCategories = array_merge($modulesCategories, $gamification['categories']);
                }
                //Seed categories
                if (isset($gamification['activities']) && is_array($gamification['activities'])) {
                    $modulesActivities = array_merge($modulesActivities, $gamification['activities']);
                }
            }
        }

        //Seed the data
        if (count($modulesCategories)) {
            $this->seedCategories($modulesCategories);
        }
        if (count($modulesActivities)) {
            $this->seedActivities($modulesActivities);
        }
    }

    /**
     * Seed the categories
     */
    public function seedCategories($data)
    {
        //Instance the repository
        $categoryRepository = app('Modules\Igamification\Repositories\CategoryRepository');
        //Search all categories
        $categories = $categoryRepository->whereIn('system_name', array_column($data, 'systemName'))->get();
        foreach ($data as $syncCategory) {
            //validate if category already exist
            $existCategory = $categories->where('system_name', $syncCategory['systemName'])->first();
            if (! $existCategory) {
                //Create category
                $category = $categoryRepository->create([
                    'system_name' => $syncCategory['systemName'],
                    'status' => 1,
                    'options' => [
                        'categoryView' => $syncCategory['categoryView'] ?? 'card',
                        'activityView' => $syncCategory['activityView'] ?? 'listButton',
                        'icon' => $syncCategory['icon'] ?? 'fa-light fa-gamepad-modern',
                    ],
                ]);
                //Create translations
                \DB::table('igamification__category_translations')->insert(array_map(function ($locale) use ($category, $syncCategory) {
                    return [
                        'category_id' => $category->id,
                        'title' => trans($syncCategory['title'], [], $locale),
                        'description' => isset($syncCategory['description']) ? trans($syncCategory['description'], [], $locale) : null,
                        'summary' => isset($syncCategory['summary']) ? trans($syncCategory['summary'], [], $locale) : null,
                        'slug' => '',
                        'locale' => $locale,
                    ];
                }, ['es', 'en']));
                //Add mainImage
                $this->syncMediafile($category, $syncCategory);
            }
        }
    }

    /**
     * Seed the activities
     */
    public function seedActivities($data)
    {
        //Get categories
        $activityRepository = app('Modules\Igamification\Entities\Activity');
        $activities = $activityRepository->whereIn('system_name', array_column($data, 'systemName'))->get();
        //Get categories
        $categoryRepository = app('Modules\Igamification\Repositories\CategoryRepository');
        $categories = $categoryRepository->whereIn('system_name', array_column($data, 'categoryId'))->get();
        //Get forms
        $formRepository = app('Modules\Iforms\Repositories\FormRepository');
        $forms = $formRepository->whereIn('system_name', array_column($data, 'formId'))->get();
        //Get roles
        $rolRepository = app('Modules\Iprofile\Repositories\RoleApiRepository');
        $roles = $rolRepository->whereIn('slug', array_merge(...array_column($data, 'roles')))->get();

        //Sync activities
        foreach ($data as $syncActivity) {
            //validate if category already exist
            $existActivity = $activities->where('system_name', $syncActivity['systemName'])->first();
            if (! $existActivity) {
                $categoryId = $categories->where('system_name', $syncActivity['categoryId'])->pluck('id')->first();
                //Create category
                $activity = $activityRepository->create([
                    'system_name' => $syncActivity['systemName'],
                    'url' => $syncActivity['url'] ?? null,
                    'category_id' => $categoryId,
                    'type' => $syncActivity['type'],
                    'status' => 1,
                    'options' => [
                        'externalScript' => $syncActivity['externalScript'] ?? null,
                        'iframe' => $syncActivity['iframe'] ?? null,
                        'tourElement' => $syncActivity['tourElement'] ?? null,
                        'tourElementPosition' => $syncActivity['tourElementPosition'] ?? null,
                        'roles' => $roles->whereIn('slug', ($syncActivity['roles'] ?? []))->pluck('id')->toArray(),
                        'icon' => $syncActivity['icon'] ?? 'fa-light fa-check-to-slot',
                    ],
                ]);
                //Sync categories
                $activity->categories()->attach($categoryId);
                //Sync forms
                if (isset($syncActivity['formId']) && $syncActivity['formId']) {
                    $activity->forms()->attach($forms->where('system_name', $syncActivity['formId'])->pluck('id')->first());
                }
                //Create translations
                \DB::table('igamification__activity_translations')->insert(array_map(function ($locale) use ($activity, $syncActivity) {
                    return [
                        'activity_id' => $activity->id,
                        'title' => trans($syncActivity['title'], [], $locale),
                        'description' => isset($syncActivity['description']) ? trans($syncActivity['description'], [], $locale) : null,
                        'locale' => $locale,
                    ];
                }, ['es', 'en']));
                //Add mainImage
                $this->syncMediafile($activity, $syncActivity);
            }
        }
    }

    public function syncMediafile($entity, $data)
    {
        if (isset($data['mainImage']) && $data['mainImage']) {
            //Instance the file path
            $filePath = $data['mainImage'];
            //Instance file service
            $fileService = app("Modules\Media\Services\FileService");
            //Search the file id in the uploaded files
            $fileId = $this->uploadedFiles[$filePath] ?? null;
            //create file
            if (! $fileId) {
                //Get base64 file
                $uploadedFile = getUploadedFileFromUrl(url($filePath));
                //Create file
                $file = $fileService->store($uploadedFile, 0, 'publicmedia');
                //set file if
                $fileId = $file->id;
                $this->uploadedFiles[$filePath] = $fileId;
            }
            //Sync file id
            $entity->files()->attach($fileId, ['zone' => 'mainimage']);
        }
    }
}
