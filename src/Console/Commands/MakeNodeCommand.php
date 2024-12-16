<?php

namespace Farouter\Console\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeNodeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'far:node {name : The name of the node}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new Farouter Node class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Node';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../../../stubs/node.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\Farouter\\Nodes';
    }
}
