<?php

/** @var \Aura\Router\Map $map */

$map->route('about', '/ueber')
    ->defaults([
        'controller' => 'about',
        'action' => 'index'
    ]);

$map->route('user', '/user/{name}')
    ->defaults([
        'controller' => 'user',
        'action' => 'index'
    ]);

$map->route('default', '{/controller,action,id}')
    ->defaults([
        'controller' => 'default',
        'action' => 'index'
    ]);

