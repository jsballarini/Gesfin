<?php

return [
    // Rotas Públicas
    'GET|/login' => ['AuthController', 'index'],
    'POST|/login' => ['AuthController', 'login'],
    'POST|/logout' => ['AuthController', 'logout'],

    // Rotas Autenticadas (Protegidas)
    'GET|/' => ['DashboardController', 'index'],
    'GET|/dashboard' => ['DashboardController', 'index'],
    
    // Categorias
    'GET|/categories' => ['CategoryController', 'index'],
    'POST|/categories/store' => ['CategoryController', 'store'],
    'POST|/categories/update' => ['CategoryController', 'update'],

    // Perfil
    'POST|/profile/update' => ['ProfileController', 'update'],

    // Lançamentos
    'GET|/entries' => ['EntryController', 'index'],
    'POST|/entries/store' => ['EntryController', 'store'],
    'POST|/entries/update' => ['EntryController', 'update'],
    'POST|/entries/delete' => ['EntryController', 'delete'],
    'POST|/entries/delete-future' => ['EntryController', 'deleteFuture'],
    'POST|/entries/toggle-status' => ['EntryController', 'toggleStatus'],
];