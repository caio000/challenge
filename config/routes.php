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
    ],
    [
        'url' => '/',
        'method' => 'get',
        'controller' => [
            'namespace' => 'app\controllers\WebController',
            'action' => 'index',
        ],
    ],

    // ------------------rotas de usuários-------------------
    [
        'url' => '/usuarios',
        'method' => 'get',
        'controller' => [
            'namespace' => 'app\controllers\UsuariosController',
            'action' => 'lista',
        ],
    ],
    [
        'url' => '/usuario/salvar',
        'method' => 'post',
        'controller' => [
            'namespace' => 'app\controllers\UsuariosController',
            'action' => 'salvar',
        ],
    ],
    [
        'url' => '/usuario/cadastrar',
        'method' => 'get',
        'controller' => [
            'namespace' => 'app\controllers\UsuariosController',
            'action' => 'cadastrar'
        ]
    ],
    [
        'url' => '/usuario/editar/:id',
        'method' => 'get',
        'controller' => [
            'namespace' => 'app\controllers\UsuariosController',
            'action' => 'editar',
        ]
    ],

    // ------------------rotas de editoras--------------------
    [
        'url' => '/editoras',
        'method' => 'get',
        'controller' => [
            'namespace' => 'app\controllers\EditorasController',
            'action' => 'lista'
        ]
    ],
    [
        'url' => '/editora/cadastrar',
        'method' => 'get',
        'controller' => [
            'namespace' => 'app\controllers\EditorasController',
            'action' => 'cadastrar'
        ],
    ],
    [
        'url' => '/editora/salvar',
        'method' => 'post',
        'controller' => [
            'namespace' => 'app\controllers\EditorasController',
            'action' => 'salvar',
        ],
    ],
    [
        'url' => '/editora/editar/:id',
        'method' => 'get',
        'controller' => [
            'namespace' => 'app\controllers\EditorasController',
            'action' => 'editar',
        ],
    ],

    // ------------------rotas de livros----------------------
    [
        'url' => '/livros',
        'method' => 'get',
        'controller' => [
            'namespace' => 'app\controllers\LivrosController',
            'action' => 'lista'
        ],
    ],
    [
        'url' => '/livro/cadastrar',
        'method' => 'get',
        'controller' => [
            'namespace' => 'app\controllers\LivrosController',
            'action' => 'cadastrar'
        ],
    ],
    [
        'url' => '/livro/salvar',
        'method' => 'post',
        'controller' => [
            'namespace' => 'app\controllers\LivrosController',
            'action' => 'salvar'
        ],
    ],
    [
        'url' => '/livro/editar/:id',
        'method' => 'get',
        'controller' => [
            'namespace' => 'app\controllers\LivrosController',
            'action' => 'editar'
        ],
    ],

    // ----------------rotas de emprestimo----------------------
    [
        'url' => '/emprestimo',
        'method' => 'get',
        'controller' => [
            'namespace' => 'app\controllers\EmprestimosController',
            'action' => 'lista',
        ],
    ],
    [
        'url' => '/emprestimo/novo',
        'method' => 'get',
        'controller' => [
            'namespace' => 'app\controllers\EmprestimosController',
            'action' => 'cadastro',
        ],
    ],
    [
        'url' => '/emprestimo/salvar',
        'method' => 'post',
        'controller' => [
            'namespace' => 'app\controllers\EmprestimosController',
            'action' => 'salvar',
        ],
    ],
    [
        'url' => '/emprestimo/devolver/:id',
        'method' => 'get',
        'controller' => [
            'namespace' => 'app\controllers\EmprestimosController',
            'action' => 'devolver',
        ],
    ],
];