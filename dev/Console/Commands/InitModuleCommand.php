<?php

namespace Dev\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InitModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:init-module {module : The name of the module.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the module initial directories';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $module = $this->argument('module');

        $moduleDirectories = [
            'Models',
            'Controllers',
            'Factories',
            'Policies',
            'Providers',
            'Requests',
            'Resources',
            'routes',
        ];

        //create module main dir.
        if (!File::exists(app_path($module))) {
            File::makeDirectory(app_path($module));
        }

        foreach ($moduleDirectories as $directory) {
            if (!File::exists(app_path($module . DIRECTORY_SEPARATOR . $directory))) {
                File::makeDirectory(app_path($module . DIRECTORY_SEPARATOR . $directory));
            }
        }

        //set this as current directory.
        $this->call('app:module', [
            'module' => $module,
        ]);

        $this->info($module . ' initialized successfully.');

        return 0;
    }
}
