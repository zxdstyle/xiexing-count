<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019-11-08
 * Time: 16:14
 */

namespace Zxdstyle\Count;

use Illuminate\Support\Facades\Route;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'xiexing');

        Route::group($this->routesConfig(), function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/xiexing.php');
        });
    }

    /**
     * @return array
     */
    protected function routesConfig()
    {
        return [
            'prefix'     => config('xiexing.count.route.prefix'),
            'namespace'  => 'Zxdstyle\Count\Http\Controllers',
            'domain'     => config('xiexing.count.domain', null),
            'middleware' => 'web',
        ];
    }

    public function register()
    {
        $this->registerConfigs();

        $this->app->singleton(Count::class, function(){
            return new Count();
        });

        $this->app->alias(Count::class, 'count');
    }

    public function provides()
    {
        return [Count::class, 'count'];
    }

    /**
     * Register the package configs.
     */
    protected function registerConfigs()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/publishable/config/xiexing.php',
            'xiexing'
        );
    }
}
