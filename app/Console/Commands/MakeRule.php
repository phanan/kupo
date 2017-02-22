<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeRule extends GeneratorCommand
{
    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Rule';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:rule {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new checklist rule';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../stubs/rule.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param string $rootNamespace
     *
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Rules';
    }
}
