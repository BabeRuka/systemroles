<?php

namespace BabeRuka\SystemRoles\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MigrateSystemRolesCommand extends Command
{
    protected $signature = 'systemroles:migrate';
    protected $description = 'Run the migrations specifically for the SystemRoles package';

    public function handle()
    {
        $migrationPath = __DIR__ . '/../../../database/migrations';

        if (is_dir($migrationPath)) {
            $this->info('Running SystemRoles migrations...');

            $migrator = $this->laravel->make('migrator');

            if (! $migrator->repositoryExists()) {
                $migrator->createRepository();
            }

            $files = $this->laravel['files']->glob($migrationPath . '/*.php');

            $ran = $migrator->run($files);

            if (! empty($ran)) {
                $this->info('Migrated: ' . implode(', ', $ran));
                $this->info('SystemRoles migrations complete.');
            } else {
                $this->info('No SystemRoles migrations to run.');
            }
        } else {
            $this->error("SystemRoles migration directory not found at: $migrationPath");
        }
    }
}
