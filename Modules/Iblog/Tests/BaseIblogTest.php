<?php

namespace Modules\Iblog\Tests;

use Faker\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Maatwebsite\Sidebar\SidebarServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Mcamara\LaravelLocalization\LaravelLocalizationServiceProvider;
use Modules\Core\Providers\CoreServiceProvider;

use Modules\Iblog\Providers\EventServiceProvider;
use Modules\Iblog\Providers\IblogServiceProvider;
use Modules\Iblog\Repositories\PostRepository;
use Modules\Iblog\Repositories\CategoryRepository;

use Modules\Page\Providers\PageServiceProvider;
use Modules\Setting\Providers\SettingServiceProvider;
use Modules\Setting\Repositories\SettingRepository;
use Modules\Tag\Providers\TagServiceProvider;
use Nwidart\Modules\LaravelModulesServiceProvider;

use Tests\ImaginaBaseTestCase;


use Illuminate\Database\SQLiteConnection;
use Illuminate\Database\Schema\{SQLiteBuilder, Blueprint};
use Illuminate\Support\Fluent;

abstract class BaseIblogTest extends ImaginaBaseTestCase
{
    /**
     * @var PostRepository
     */
    protected $post;
    /**
     * @var CategoryRepository
     */
    //protected $postCategory;

    /**
     *
     */
    public function setUp()
    {
        $this->hotfixSqlite();
        parent::setUp();

        $this->resetDatabase();

        $this->post = app(PostRepository::class);
        //$this->postCategory = app(CategoryRepository::class);
        app(SettingRepository::class)->createOrUpdate([
            'core::locales' => ['en', 'fr',],
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelModulesServiceProvider::class,
            CoreServiceProvider::class,
            TagServiceProvider::class,
            PageServiceProvider::class,
            SettingServiceProvider::class,
            EventServiceProvider::class,
            IblogServiceProvider::class,
            LaravelLocalizationServiceProvider::class,
            SidebarServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app)
    {
        return [
            'Eloquent' => Model::class,
            'LaravelLocalization' => LaravelLocalization::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['path.base'] = __DIR__ . '/..';
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', array(
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ));
        $app['config']->set('translatable.locales', ['en', 'fr']);
    }

    private function resetDatabase()
    {
        // Makes sure the migrations table is created
        $this->artisan('migrate', [
            '--database' => 'sqlite',
        ]);

        $this->artisan('migrate', [
            '--database' => 'sqlite',
            '--path'     => 'Modules/Setting/Database/Migrations',
        ]);

        $this->artisan('migrate', [
            '--database' => 'sqlite',
            '--path'     => 'Modules/Page/Database/Migrations',
        ]);
        $this->artisan('migrate', [
            '--database' => 'sqlite',
            '--path'     => 'Modules/Tag/Database/Migrations',
        ]);
        $this->artisan('migrate', [
            '--database' => 'sqlite',
            '--path'     => 'Modules/Setting/Database/Migrations',
        ]);


    }

    public function createMenu($name, $title)
    {
        $data = [
            'name' => $name,
            'primary' => true,
            'en' => [
                'title' => $title,
                'status' => 1,
            ],
        ];

        return $this->menu->create($data);
    }

    /**
     * Create a menu item for the given menu and position
     *
     * @param  int    $menuId
     * @param  int    $position
     * @param  null   $parentId
     * @return object
     */
    protected function createMenuItemForMenu($menuId, $position, $parentId = null)
    {
        $faker = Factory::create();

        $title = implode(' ', $faker->words(3));
        $slug = Str::slug($title);

        $data = [
            'menu_id' => $menuId,
            'position' => $position,
            'parent_id' => $parentId,
            'target' => '_self',
            'module_name' => 'blog',
            'en' => [
                'status' => 1,
                'title' => $title,
                'uri' => $slug,
            ],
            'fr' => [
                'status' => 1,
                'title' => $title,
                'uri' => $slug,
            ],
        ];

        return $this->menuItem->create($data);
    }



}
