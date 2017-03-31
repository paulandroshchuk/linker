<?php

$router->post('/links', 'Client\LinksController@store')->name('links.store');
$router->get('/links/{link}', 'Client\LinksController@show');
