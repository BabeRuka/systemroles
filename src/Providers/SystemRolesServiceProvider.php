<?php

namespace BabeRuka\SystemRoles\Providers; 

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;  
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Routing\Router;  

class SystemRolesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register related providers
        $this->app->register(RouteServiceProvider::class);

        // Bind service
        $this->app->singleton(SystemRolesService::class, function ($app) {
            return new \BabeRuka\SystemRoles\Services\SystemRolesService();
        });

        // Facade
        $this->app->bind('systemroles', static function (Application $app) {
            return $app->make(\BabeRuka\SystemRoles\Services\SystemRolesService::class);
        });

        // Helper Facade Binding
        $this->app->bind('systemroles.helper', \BabeRuka\SystemRoles\Helpers\Helper::class);

        // Config
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/systemroles.php',
            'systemroles'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->publishes([__DIR__.'/../../config/systemroles.php' => config_path('systemroles.php'),], 'systemroles-config');
        if ($this->app->runningInConsole()) {
            $this->commands([
                \BabeRuka\SystemRoles\Console\Commands\MigrateSystemRolesCommand::class,
            ]);
            $this->loadSeedersFrom(__DIR__.'/../../database/seeders');
        }
        $this->publishes([
            __DIR__.'/../../assets/css' => public_path('vendor/systemroles/css'),
            __DIR__.'/../../assets/js' => public_path('vendor/systemroles/js'),
            __DIR__.'/../../assets/fonts' => public_path('fonts'),  
            __DIR__.'/../../assets/images' => public_path('images'),  
            __DIR__.'/../../assets/addons' => public_path('addons'),  
        ], 'systemroles-assets');

        $this->publishes([
            __DIR__.'/../../resources/views/systemroles' => resource_path('views/vendor/systemroles'),
        ], 'systemroles-views');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \BabeRuka\SystemRoles\Console\Commands\MigrateSystemRolesCommand::class,
            ]);
        }
    

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'systemroles');
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->loadRoutesFrom(__DIR__.'/../../routes/web.php'); 
        $this->loadRoutesFrom(__DIR__.'/../../routes/api.php');

        // Register middleware
        $router->aliasMiddleware('super_admin', \BabeRuka\SystemRoles\Http\Middleware\SuperAdminMiddleware::class);
    }
}
