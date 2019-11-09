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

        if ($this->app->runningInConsole()) {
            $this->registerPublishableResources();
        }

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

    /**
     * Register the publishable files.
     */
    protected function registerPublishableResources()
    {
        $publishablePath = dirname(__DIR__) . '/publishable';

        $publishable = [
            'xiexing_config' => [
                "{$publishablePath}/config/xiexing.php" => config_path('xiexing.php'),
            ],
            'xiexing_assets' => [
                "{$publishablePath}/assets/" => public_path('vendor/xiexing/assets'),
            ],
            'xiexing_views' => [
                dirname(__DIR__) . "/resources/views/" => resource_path('views/vendor/xiexing'),
            ],
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }
}
