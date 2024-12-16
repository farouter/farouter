<?php

namespace Farouter\Console\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'far:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install and configure the Farouter package';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Installing Farouter...');

        // Публікація конфігурації
        $this->call('vendor:publish', [
            '--tag' => 'farouter-config',
            '--force' => true,
        ]);
        $this->info('Configuration published.');

        // Публікація ресурсів
        $this->call('vendor:publish', [
            '--tag' => 'farouter-resources',
            '--force' => true,
        ]);
        $this->info('Migrations published.');

        $this->info('Farouter installed successfully!');

        return self::SUCCESS;
    }
}
