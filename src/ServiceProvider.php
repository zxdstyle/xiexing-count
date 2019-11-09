<?php
/**
 * Created by PhpStorm.
 * User: mac
 * Date: 2019-11-08
 * Time: 16:14
 */

namespace Zxdstyle\Count;


class ServiceProvider
{
    public function register()
    {
        $this->app->singleton(Count::class, function(){
            return new Count();
        });

        $this->app->alias(Count::class, 'count');
    }

    public function provides()
    {
        return [Count::class, 'count'];
    }
}
