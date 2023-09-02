<?php

namespace Modules\Isite\Console;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\DatabaseManager;
use Modules\Isite\Entities\Organization;
use Nwidart\Modules\Commands\MigrateCommand;
use Symfony\Component\Console\Input\InputArgument;

class TenantModuleMigrateCommand extends MigrateCommand
{
    protected $config;

    /**
     * @param  EnvFileWriter  $env
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        parent::__construct();
    }

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'tenant:module:migrate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate the migrations from the specified module or from all modules inside a Tenant DB.';

    /**
     * @var \Nwidart\Modules\Contracts\RepositoryInterface
     */
    protected $module;

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->module = $this->laravel['modules'];

        $name = $this->argument('module');

        $tenant = $this->argument('tenant');

        Organization::findOrFail($tenant);

        tenancy()->initialize($tenant);

        $driver = env('DB_CONNECTION', 'mysql');

        $this->config['database.default'] = $driver;
        $this->config['database.connections.'.$driver.'.host'] = env('DB_HOST', '127.0.0.1');
        $this->config['database.connections.'.$driver.'.port'] = env('DB_PORT', 3306);
        $this->config['database.connections.'.$driver.'.database'] = tenant()->tenancy_db_name;
        $this->config['database.connections.'.$driver.'.username'] = tenant()->tenancy_db_username;
        $this->config['database.connections.'.$driver.'.password'] = tenant()->tenancy_db_password;

        app(DatabaseManager::class)->purge($driver);
        app(ConnectionFactory::class)->make($this->config['database.connections.'.$driver], $driver);

        if (! empty($name)) {
            $this->call('module:migrate', ['module' => $name]);
        } else {
            $this->call('module:migrate');
        }

        return 0;
    }

    /**
     * Get the console command arguments.
     */
    protected function getArguments()
    {
        return [
            ['tenant', InputArgument::REQUIRED, 'Tenant id.'],
            ['module', InputArgument::OPTIONAL, 'The name of module will be used.'],
        ];
    }
}
