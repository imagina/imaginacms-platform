<?php

namespace Modules\Workshop\Console;

use Illuminate\Console\Command;
use Modules\Workshop\Scaffold\Theme\ThemeScaffold;

class ThemeScaffoldCommand extends Command
{
    protected $signature = 'asgard:theme:scaffold';

    protected $description = 'Scaffold a new theme';

    /**
     * @var ThemeScaffold
     */
    private $themeScaffold;

    public function __construct(ThemeScaffold $themeScaffold)
    {
        parent::__construct();
        $this->themeScaffold = $themeScaffold;
    }

    public function handle(): void
    {
        $themeName = $this->ask('Please enter the theme name in the following format: vendor/name');
        [$vendor, $name] = $this->separateVendorAndName($themeName);

        $type = $this->choice('Would you like to create a front end or backend theme ?', ['Frontend', 'Backend'], 0);

        $this->themeScaffold->setName($name)->setVendor($vendor)->forType(strtolower($type))->generate();

        $this->info("Generated a fresh theme called [$themeName]. You'll find it in the Themes/ folder");
    }

    /**
     * Extract the vendor and module name as two separate values
     */
    private function separateVendorAndName(string $fullName): array
    {
        $explodedFullName = explode('/', $fullName);

        return [
            $explodedFullName[0],
            ucfirst($explodedFullName[1]),
        ];
    }
}
