<?php
namespace WFN\Admin\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use WFN\Admin\Http\Middleware\Admin as AdminMiddleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\AliasLoader;
use WFN\Admin\Model\Alert;
use WFN\Admin\Model\Navigation;
use WFN\Admin\Model\Settings;
use WFN\Admin\Model\User;

class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->commands([
            \WFN\Admin\Console\Commands\CreateAdminUser::class,
            \WFN\Admin\Console\Commands\CreateAdminUserRole::class
        ]);

        $this->app->booting(function() {
            $loader = AliasLoader::getInstance();
            $loader->alias('Alert', Alert::class);
            $loader->alias('AdminNavigation', Navigation::class);
            $loader->alias('Settings', Settings::class);
            $loader->alias('AdminUser', User::class);
        });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        $basePath = realpath(__DIR__ . '/..');
        Route::middleware('web')->group($basePath . '/routes/web.php');
        $this->loadViewsFrom($basePath . '/views', 'admin');

        $this->publishes([
            $basePath . '/views' => resource_path('views/vendor/admin'),
        ]);
        $this->publishes([
            $basePath . '/assets' => public_path('adminhtml'),
        ], 'public');

        $this->loadMigrationsFrom($basePath . '/database/migrations');

        $router->aliasMiddleware('admin', AdminMiddleware::class);

        $this->mergeConfigFrom($basePath . '/Config/settings.php', 'settings');
        $this->mergeConfigFrom($basePath . '/Config/adminNavigation.php', 'adminNavigation');
        $this->mergeConfigFrom($basePath . '/Config/auth.php', 'auth');

        $this->app['config']['admin_base_path'] = $basePath;
    }

    /**
     * Merge the given configuration with the existing configuration.
     *
     * @param  string  $path
     * @param  string  $key
     * @return void
     */
    protected function mergeConfigFrom($path, $key)
    {
        $config = $this->app['config']->get($key, []);
        $this->app['config']->set($key, $this->mergeConfig($config, require $path));
    }

    /**
     * Merges the configs together and takes multi-dimensional arrays into account.
     *
     * @param  array  $original
     * @param  array  $merging
     * @return array
     */
    protected function mergeConfig(array $original, array $merging)
    {
        $array = array_merge($original, $merging);
        foreach ($original as $key => $value) {
            if (! is_array($value)) {
                continue;
            }
            if (! Arr::exists($merging, $key)) {
                continue;
            }
            if (is_numeric($key)) {
                continue;
            }
            $array[$key] = $this->mergeConfig($value, $merging[$key]);
        }
        return $array;
    }

}
