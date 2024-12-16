<?php

namespace Farouter\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

class MakeResourceCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'far:resource {name : The name of the resource}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new Farouter Resource class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Resource';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/../../../stubs/resource.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\\Farouter\\Resources';
    }

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     */
    protected function buildClass($name)
    {
        $class = parent::buildClass($name);

        // Отримуємо поточний неймспейс класу
        $namespace = $this->getNamespace($name);
        $baseResourceNamespace = 'App\\Farouter\\Resources\\Resource';

        // Визначаємо значення для {{ useResource }}
        $useResource = $namespace === 'App\\Farouter\\Resources'
            ? '' // У базовій директорії імпорт не потрібен
            : "use {$baseResourceNamespace};";

        // Замінюємо {{ useResource }} у стабі
        $class = str_replace('{{ useResource }}', $useResource, $class);

        // Замінюємо {{ model }} на згенеровану модель
        $modelClass = $this->guessModelClass($name);
        $class = str_replace('{{ model }}', $modelClass, $class);

        // Видаляємо зайвий порожній рядок, якщо {{ useResource }} порожній
        $class = preg_replace("/\n\n\n/", "\n\n", $class);

        return $class;
    }

    /**
     * Guess the fully qualified class name for the model.
     */
    protected function guessModelClass(string $name): string
    {
        // Вилучаємо тільки шлях до моделі
        $relativePath = str_replace('\\', '/', $this->argument('name'));
        $modelPath = collect(explode('/', $relativePath))
            ->map(fn ($segment) => Str::studly($segment)) // Приводимо до StudlyCase
            ->implode('\\'); // Формуємо повний шлях для неймспейсу

        return "App\\Models\\{$modelPath}";
    }
}
