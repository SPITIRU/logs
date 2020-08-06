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
        if (function_exists('config_path')) { // function not available and 'publish' not relevant in Lumen
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

//        $permissionLoader->clearClassPermissions();
//        $permissionLoader->registerPermissions();

//        $this->app->singleton(PermissionRegistrar::class, function ($app) use ($permissionLoader) {
//            return $permissionLoader;
//        });
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php',
            'artLog'
        );

//        $this->app->bind('smo', function () {
//            return new Smo;
//        }, true);
//        $this->app->bindIf('smo', function () {
//            return new Smo;
//        }, true);
//        $this->app->singleton('smo', function ($app) {
//            return new Smo;
//        });
//
//
//        $this->app->bindMethod('smoBind', function (){
//            return 1123;
//        });
//        $this->app->instance('smo', Smo::class);
//        $this->app->alias('smo', Smo::class);
//        $r = \Closure::fromCallable(function (){
//            return 2 + 3;
//        });
//        $this->app->extend('smo', $r);
//        dd($this->app->make('smo'));
//        dd($this->app->isAlias(Smo::class));
//        dd($this->app->make(Smo::class));
//        $this->app->__set(222,2);
//        dd($this->app->__get(222));
//        dd($this->app->bound(Smo::class));
//        dd($this->app->has('smo'));
//        dd($this->app->resolved(Smo::class));
//        dd($this->app->isShared('smo'));
//        dd($this->app->hasMethodBinding('smoBind'));

//        dd($this->app->callMethodBinding('smoBind',Smo::class));
//            dd(SmoFacade::generate());

//        $this->registerBladeExtensions();
    }

    protected function registerModelBindings()
    {
        $config = $this->app->config['artLog.models'];

        if (!$config) {
            return;
        }

        $this->app->bind(Log::class, $config['log']);
        $this->app->bind(LogService::class, LogService::class);

//        dd($this->app);
    }

    protected function registerMacroHelpers()
    {
        if (! method_exists(Route::class, 'macro')) { // Lumen
            return;
        }

//        Route::macro('role', function ($roles = []) {
//            if (! is_array($roles)) {
//                $roles = [$roles];
//            }
//
//            $roles = implode('|', $roles);
//
//            $this->middleware("role:$roles");
//
//            return $this;
//        });
//
//        Route::macro('permission', function ($permissions = []) {
//            if (! is_array($permissions)) {
//                $permissions = [$permissions];
//            }
//
//            $permissions = implode('|', $permissions);
//
//            $this->middleware("permission:$permissions");
//
//            return $this;
//        });
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
