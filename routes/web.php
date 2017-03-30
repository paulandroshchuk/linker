<?php

$router->group(['namespace' => 'Client'], function ($router) {
    $router->get('/', 'IndexController')->name('index.index');
    $router->get('/{link}', 'LinksController@show')->name('links.show');
});
