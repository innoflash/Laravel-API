<?php

namespace Dev\Console\Commands;

use Dev\Abstracts\ModuleChecker;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

abstract class ContractMakeCommand extends Command
{
    protected ModuleChecker $moduleChecker;
    protected string $modelName;
    protected string $contractName;

    /**
     * Fetches the type of the file.
     * @return string
     */
    abstract function getType(): string;

    /**
     * Fetches the name of the stub for the contract.
     * @return string
     */
    abstract function getContractStub(): string;

    /**
     * Fetches the name of the stub used for the implementation.
     * @return string
     */
    abstract function getImplementationStub(): string;

    /**
     * Gets the folder in which the contract should be written.
     * @return string
     */
    protected function getContractDir(): string
    {
        return Str::plural($this->getType());
    }

    public function __construct()
    {
        parent::__construct();
        $this->moduleChecker = resolve(ModuleChecker::class);
    }

    /**
     * Resolves module checker.
     * @return ModuleChecker
     */
    public function getModuleChecker(): ModuleChecker
    {
        return $this->moduleChecker;
    }

    /**
     * Gets the model name.
     * @return string
     */
    public function getModelName(): string
    {
        return $this->modelName;
    }

    /**
     * Fetches the contract name
     * @return string
     */
    public function getContractName(): string
    {
        return $this->contractName;
    }

    public function handle()
    {
        $this->moduleChecker->checkModule();

        if (!$this->modelName = $this->option('model')) {
            $this->modelName = $this->ask('Please enter the name of the model you are using.');
        }

        $this->contractName = $this->modelName . $this->getType();
        $this->contractName = $this->ask('Whats the name of the ' . Str::lower($this->getType()) . '?',
            $this->contractName);

        $this->afterContractNameInit();

        $contractStubData               = File::get($this->getContractStub());
        $contractImplementationStubData = File::get($this->getImplementationStub());

        $this->initializeDirectories();

        //build class/interface data.
        $contractStubData               = $this->replaceStubData($contractStubData);
        $contractImplementationStubData = $this->replaceStubData($contractImplementationStubData);

        //create repository contract file.
        $this->buildContractFile($contractStubData);

        //create repository implementation.
        $this->buildImplementationFile($contractImplementationStubData);

        $this->info('Don`t forget to bind the ' . Str::lower($this->getType()) . ' in the service provider.');

        return 0;
    }

    /**
     * Builds the contract.
     *
     * @param string $data
     *
     * @throws \Dev\Exceptions\NoModuleSetException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    private function buildContractFile(string $data)
    {
        $contractFileName = app_path($this->getModuleChecker()->module() . '/Contracts/' . $this->getContractDir() . '/' . $this->contractName . '.php');
        if (!File::exists($contractFileName)) {
            File::put($contractFileName, $data);
            $this->info($this->contractName . ' created successfully');
        } else {
            $this->warn($this->contractName . ' already exists');
        }
    }

    /**
     * Builds the implementation file.
     *
     * @param $data
     *
     * @throws \Dev\Exceptions\NoModuleSetException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    private function buildImplementationFile($data)
    {
        $implementationFileName = app_path($this->getModuleChecker()->module() . '/' . $this->getContractDir() . '/Default' . $this->contractName . '.php');
        if (!File::exists($implementationFileName)) {
            File::put($implementationFileName, $data);
            $this->info($this->contractName . ' implementation created successfully');
        } else {
            $this->warn($this->contractName . ' implementation already exists');
        }
    }

    /**
     * Creates or check if these contract folders exist.
     * @throws \Dev\Exceptions\NoModuleSetException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function initializeDirectories()
    {
        //check or create a contracts folder
        $contractsDir = app_path($this->moduleChecker->module() . '/Contracts');
        $contractDir  = app_path($this->moduleChecker->module() . '/Contracts/' . $this->getContractDir());

        if (!File::isDirectory($contractsDir)) {
            File::makeDirectory($contractsDir);
        }

        if (!File::isDirectory($contractDir)) {
            File::makeDirectory($contractDir);
        }

        //check if implementation folder exist or create.
        if (!File::isDirectory(app_path($this->moduleChecker->module() . DIRECTORY_SEPARATOR . $this->getContractDir()))) {
            File::makeDirectory(app_path($this->moduleChecker->module() . DIRECTORY_SEPARATOR . $this->getContractDir()));
        }
    }

    /**
     * Changes data from the stub.
     *
     * @param string $data
     *
     * @return \Illuminate\Support\Stringable
     * @throws \Dev\Exceptions\NoModuleSetException
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function replaceStubData(string $data)
    {
        return Str::of($data)
                  ->replace([
                      '{{module}}',
                      '{{class}}',
                      '{{model}}',
                      '{{model_var}}',
                  ], [
                      $this->moduleChecker->module(),
                      $this->contractName,
                      $this->modelName,
                      Str::camel($this->modelName),
                  ]);
    }

    /**
     * Do something after all names have been initialized
     */
    protected function afterContractNameInit()
    {

    }
}
