<?php

namespace Dev\Console\Commands;

class MakeQueryServiceCommand extends ServiceContractMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:query-service {--m|model= : The model to be created a repository for.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a query service for a model';

    /**
     * @inheritDoc
     */
    function getType(): string
    {
        return 'QueryService';
    }

    /**
     * @inheritDoc
     */
    function getContractStub(): string
    {
        return __DIR__ . '/../stubs/query-service-contract.stub';
    }

    /**
     * @inheritDoc
     */
    function getImplementationStub(): string
    {
        return __DIR__ . '/../stubs/query-service-impl.stub';
    }

    /**
     * @inheritDoc
     */
    function getPreCommand(): string
    {
        return 'app:repository';
    }
}
