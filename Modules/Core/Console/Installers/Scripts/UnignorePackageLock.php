<?php

namespace Modules\Core\Console\Installers\Scripts;

use Illuminate\Console\Command;
use Modules\Core\Console\Installers\SetupScript;

class UnignorePackageLock implements SetupScript
{
    const PACKAGE_LOCK = 'package-lock.json';

    /**
     * Fire the install script
     *
     * @return mixed
     */
    public function fire(Command $command)
    {
        $gitignorePath = base_path('.gitignore');

        if (! $this->gitignoreContainsPackageLock($gitignorePath)) {
            return;
        }

        $removePackageLock = $command->confirm('Do you want to remove package-lock.json from .gitignore ?', true);
        if ($removePackageLock) {
            $out = $this->getGitignoreLinesButPackageLock($gitignorePath);
            $this->writeNewGitignore($gitignorePath, $out);
        }
    }

    private function gitignoreContainsPackageLock($gitignorePath): bool
    {
        return file_exists($gitignorePath) && strpos(file_get_contents($gitignorePath), self::PACKAGE_LOCK) !== false;
    }

    private function getGitignoreLinesButPackageLock($gitignorePath): array
    {
        $data = file($gitignorePath);
        $out = [];
        foreach ($data as $line) {
            if (trim($line) !== self::PACKAGE_LOCK) {
                $out[] = $line;
            }
        }

        return $out;
    }

    private function writeNewGitignore($gitignorePath, $out)
    {
        $fp = fopen($gitignorePath, 'wb+');
        flock($fp, LOCK_EX);
        foreach ($out as $line) {
            fwrite($fp, $line);
        }
        flock($fp, LOCK_UN);
        fclose($fp);
    }
}
