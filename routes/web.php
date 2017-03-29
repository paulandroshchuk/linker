<?php

$router->group(['namespace' => 'Client'], function ($router) {
    $router->get('/', 'IndexController')->name('index.index');
    $router->post('/links', 'LinksController@store')->name('links.store');
});
