<?php

namespace Modules\Core\Console\Installers\Scripts;

use Illuminate\Console\Command;
use Modules\Core\Console\Installers\SetupScript;

class UnignoreComposerLock implements SetupScript
{
    const COMPOSER_LOCK = 'composer.lock';

    /**
     * Fire the install script
     *
     * @return mixed
     */
    public function fire(Command $command)
    {
        $gitignorePath = base_path('.gitignore');

        if (! $this->gitignoreContainsComposerLock($gitignorePath)) {
            return;
        }

        $removeComposerLock = $command->confirm('Do you want to remove composer.lock from .gitignore ?', true);
        if ($removeComposerLock) {
            $out = $this->getGitignoreLinesButComposerLock($gitignorePath);
            $this->writeNewGitignore($gitignorePath, $out);
        }
    }

    private function gitignoreContainsComposerLock($gitignorePath): bool
    {
        return file_exists($gitignorePath) && strpos(file_get_contents($gitignorePath), self::COMPOSER_LOCK) !== false;
    }

    private function getGitignoreLinesButComposerLock($gitignorePath): array
    {
        $data = file($gitignorePath);
        $out = [];
        foreach ($data as $line) {
            if (trim($line) !== self::COMPOSER_LOCK) {
                $out[] = $line;
            }
        }

        return $out;
    }

    private function writeNewGitignore($gitignorePath, $out)
    {
        $fp = fopen($gitignorePath, 'w+');
        flock($fp, LOCK_EX);
        foreach ($out as $line) {
            fwrite($fp, $line);
        }
        flock($fp, LOCK_UN);
        fclose($fp);
    }
}
