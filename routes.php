<?php

use Illuminate\Routing\Router;

// 接口
Route::group([
    'namespace' => 'Qihucms\Present\Controllers\Api',
    'prefix' => 'present',
    'middleware' => ['api'],
    'as' => 'api.'
], function (Router $router) {
    $router->get('presents', 'PresentController@presents')->name('present.index');
    $router->get('orders', 'PresentController@orders')->name('present.order');
    $router->post('givings', 'PresentController@giving')->name('present.givings');
});

// 后台
Route::group([
    'prefix' => config('admin.route.prefix') . '/present',
    'namespace' => 'Qihucms\Present\Controllers\Admin',
    'middleware' => config('admin.route.middleware'),
    'as' => 'admin.'
], function (Router $router) {
    $router->resource('presents', 'PresentController');
    $router->resource('orders', 'PresentOrderController');
});