<?php

namespace App\Providers;

use Illuminate\Foundation\Console\ServeCommand;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (PHP_OS_FAMILY === 'Windows') {
            ServeCommand::$passthroughVariables = array_values(array_unique([
                ...ServeCommand::$passthroughVariables,
                'APPDATA', 'COMPUTERNAME', 'HOMEDRIVE', 'HOMEPATH',
                'LOCALAPPDATA', 'PATHEXT', 'ProgramData', 'ProgramFiles',
                'ProgramW6432', 'SystemDrive', 'SystemRoot', 'TEMP', 'TMP',
                'USERDOMAIN', 'USERNAME', 'USERPROFILE',
            ]));
        }
    }

    public function boot(): void
    {
        //
    }
}
