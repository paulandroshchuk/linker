<?php

$router->group(['namespace' => 'Client'], function ($router) {
    $router->get('/', 'IndexController')->name('index.index');
    $router->get('/api', 'ApiController@index')->name('api.index');
    $router->get('/{link}', 'LinksController@show')->name('links.show');
    $router->post('/links/{link}', 'LinksController@verify')->name('links.verify');
});
