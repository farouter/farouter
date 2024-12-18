<?php

namespace Farouter\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

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

    /**
     * Replace placeholders in the stub file.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceNamespace(&$stub, $name)
    {
        parent::replaceNamespace($stub, $name);

        // Replace the {{ key }} placeholder with the lowercase class name
        $className = class_basename($name);
        $stub = str_replace('{{ key }}', Str::lower($className), $stub);

        return $this;
    }
}
