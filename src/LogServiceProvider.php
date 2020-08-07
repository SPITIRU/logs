<?php

namespace ArtemiyKudin\log;

use ArtemiyKudin\log\Models\Log;
use ArtemiyKudin\log\Traits\LogService;
use Illuminate\Routing\Route;
use Illuminate\Support\Collection;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class LogServiceProvider extends ServiceProvider
{
    public function boot(Filesystem $filesystem)
    {
        if (function_exists('config_path')) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('artLog.php'),
            ], 'config');

            $this->publishes([
                __DIR__ . '/../database/migrations/create_packages_logs_table.php.stub' => $this->getMigrationFileName($filesystem),
            ], 'migrations');

            $this->publishes([
                __DIR__ . '/../lang' => resource_path('/lang'),
            ], 'lang');
        }
        $this->loadFactoriesFrom(__DIR__.'/../database/factories');
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->registerModelBindings();
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php',
            'artLog'
        );
    }

    protected function registerModelBindings()
    {
        $config = $this->app->config['artLog.models'];

        if (!$config) {
            return;
        }

        $this->app->bind(Log::class, $config['log']);
        $this->app->bind(LogService::class, LogService::class);
    }

    /**
     * Returns existing migration file if found, else uses the current timestamp.
     *
     * @param Filesystem $filesystem
     * @return string
     */
    protected function getMigrationFileName(Filesystem $filesystem): string
    {
        $timestamp = date('Y_m_d_His');

        return Collection::make($this->app->databasePath().DIRECTORY_SEPARATOR.'migrations'.DIRECTORY_SEPARATOR)
            ->flatMap(function ($path) use ($filesystem) {
                return $filesystem->glob($path.'*_create_packages_logs_table.php');
            })->push($this->app->databasePath()."/migrations/{$timestamp}_create_packages_logs_table.php")
            ->first();
    }
}
