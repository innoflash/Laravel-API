<?php

namespace Dev\Console\Commands;

use Illuminate\Support\Facades\File;

abstract class ServiceContractMakeCommand extends ContractMakeCommand
{
    /**
     * Gets the commands to be executed prior to the current command.
     * @return string
     */
    abstract function getPreCommand(): string;

    protected function getContractDir(): string
    {
        return 'Services';
    }

    protected function afterContractNameInit()
    {
        $repositoryFile = app_path($this->moduleChecker->module() . '/Contracts/Services/' . $this->modelName . $this->getType() . '.php');
        if (!File::exists($repositoryFile)) {
            if ($this->confirm('The ' . $this->modelName . $this->getType() . ' does not exist, do you wanna create it now?',
                true)) {
                $this->call($this->getPreCommand(), [
                    '--model' => $this->modelName,
                ]);
            }
        }
    }
}
