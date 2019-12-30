<?php

return [
    [
        'url' => '/users/:id/history',
        'method' => 'get',
        'hasAuth' => true,
        'controller' => [
            'namespace' => 'app\controllers\UserController',
            'action' => 'history',
        ],
    ],
    [
        'url' => '/ranking',
        'method' => 'get',
        'hasAuth' => true,
        'controller' => [
            'namespace' => 'app\controllers\HomeController',
            'action' => 'ranking',
        ],
    ],
    [
        'url' => '/login',
        'method' => 'post',
        'controller' => [
            'namespace' => 'app\controllers\HomeController',
            'action' => 'login',
        ],
    ],
    [
        'url' => '/users/:id',
        'method' => 'put',
        'hasAuth' => true,
        'controller' => [
            'namespace' => 'app\controllers\UserController',
            'action' => 'update',
        ],
    ],
    [
        'url' => '/users/:id',
        'method' => 'delete',
        'hasAuth' => true,
        'controller' => [
            'namespace' => 'app\controllers\UserController',
            'action' => 'delete',
        ],
    ],
    [
        'url' => '/users/:id/drink',
        'method' => 'post',
        'hasAuth' => true,
        'controller' => [
            'namespace' => 'app\controllers\UserController',
            'action' => 'drink',
        ],
    ],
    [
        'url' => '/users',
        'method' => 'get',
        'hasAuth' => true,
        'controller' => [
            'namespace' => 'app\controllers\UserController',
            'action' => 'index',
        ]
    ],
    [
        'url' => '/users/:id',
        'method' => 'get',
        'hasAuth' => true,
        'controller' => [
            'namespace' => 'app\controllers\UserController',
            'action' => 'getOne'
        ],
    ],
    [
        'url' => '/users',
        'method'=> 'post',
        'controller' => [
            'namespace' => 'app\controllers\UserController',
            'action' => 'create',
        ]
    ]
];