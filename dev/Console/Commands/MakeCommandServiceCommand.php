<?php

namespace Dev\Console\Commands;

class MakeCommandServiceCommand extends ServiceContractMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:command-service {--m|model= : The model to be created a repository for.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a command service for a model.';

    function getType(): string
    {
        return 'CommandService';
    }

    /**
     * @inheritDoc
     */
    function getContractStub(): string
    {
        return __DIR__ . '/../stubs/command-service-contract.stub';
    }

    /**
     * @inheritDoc
     */
    function getImplementationStub(): string
    {
        return __DIR__ . '/../stubs/command-service-impl.stub';
    }

    /**
     * @inheritDoc
     */
    function getPreCommand(): string
    {
        return 'app:query-service';
    }
}
