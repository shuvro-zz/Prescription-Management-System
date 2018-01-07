<?php

use Cake\Core\Plugin;
use Cake\Routing\Router;

Router::defaultRouteClass('DashedRoute');

Router::scope('/', function ($routes) {

    $routes->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);

    $routes->fallbacks('DashedRoute');
});

Plugin::routes();

Router::scope('/admin', function ($routes) {

    /* Routes For Admin */
    Router::prefix('admin', function ($routes) {

        $routes->connect('/', ['controller' => 'Users', 'action' => 'login']);

        $routes->fallbacks('DashedRoute');


        $routes->connect('/products/combinations/add/*', ['controller' => 'Products', 'action' => 'combinationsAdd']);

    });

    $routes->fallbacks('DashedRoute');

});

Plugin::routes();

Router::defaultRouteClass('Route');




