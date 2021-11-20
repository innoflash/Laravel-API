<?php

namespace Dev\Providers;

use Core\Abstracts\Providers\CoreMainProvider;
use Dev\Console\Commands\InitModuleCommand;
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
            InitModuleCommand::class,
        ]);
    }
}
