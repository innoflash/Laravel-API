<?php

namespace Dev\Console\Commands;

class MakeRepositoryCommand extends ContractMakeCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:repository {--m|model= : The model to be created a repository for.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes a repository for a given model.';

    /**
     * @inheritDoc
     */
    function getType(): string
    {
        return 'Repository';
    }

    /**
     * @inheritDoc
     */
    function getContractStub(): string
    {
        return __DIR__ . '/../stubs/repository-contract.stub';
    }

    /**
     * @inheritDoc
     */
    function getImplementationStub(): string
    {
        return __DIR__ . '/../stubs/repository-impl.stub';
    }
}
