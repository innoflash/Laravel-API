<?php

namespace Dev\Console\Commands;

use Illuminate\Console\Command;

class SetModuleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:module {module : The name of the module.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets the module for the the repositories to be build.';

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
     * @throws \Exception
     */
    public function handle()
    {
        $module = $this->argument('module');

        cache()->forever('current_module', $module);

        $this->info("$module is set successfully as the current module.");

        return 0;
    }
}
