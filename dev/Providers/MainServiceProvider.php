<?php

namespace Dev\Providers;

use Core\Abstracts\CoreMainProvider;
use Dev\Console\Commands\MakeCommandServiceCommand;
use Dev\Console\Commands\MakeQueryServiceCommand;
use Dev\Console\Commands\MakeRepositoryCommand;
use Dev\Console\Commands\MakeServiceCommand;
use Dev\Console\Commands\SetModuleCommand;

class MainServiceProvider extends CoreMainProvider
{
    public function boot()
    {
        $this->commands([
            SetModuleCommand::class,
            MakeQueryServiceCommand::class,
            MakeRepositoryCommand::class,
            MakeServiceCommand::class,
            MakeCommandServiceCommand::class,
        ]);
    }
}