<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019-11-08
 * Time: 15:28
 */

namespace Xiexing\Count;

use Illuminate\Support\ServiceProvider as BaseServieProvider;


class ServiceProvider extends BaseServieProvider
{
    protected $defer = true;

    public function register()
    {
        $this->app->singleton(Count::class, function(){
            return new Count(config('services.weather.key'));
        });

        $this->app->alias(Count::class, 'weather');
    }

    public function provides()
    {
        return [Count::class, 'weather'];
    }
}
