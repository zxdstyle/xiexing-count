<?php

return [
    /*
    |--------------------------------------------------------------------------
    | 积分计算器路由
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of the LaRecipe docs basic route
    | where you can specify the url of your documentations, the location
    | of your docs and the landing page when a user visits /docs route.
    |
    |
    */

    'route' => [
        'prefix' => env('COUNT_ROUTE_PREFIX', ''),
        'route' => env('COUNT_ROUTE', 'count')
    ]
];
