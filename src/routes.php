<?php

return [
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
    '~^articles/(\d+)$~' => [\MyProject\Controllers\ArticlesController::class, 'view'],
    '~^articles/add$~' => [\MyProject\Controllers\ArticlesController::class, 'add'],
    '~^articles/(\d+)/edit$~' => [\MyProject\Controllers\ArticlesController::class, 'edit'],
    '~^articles/(\d+)/delete$~' => [\MyProject\Controllers\ArticlesController::class, 'delete'],
    '~^users/register$~' => [\MyProject\Controllers\UsersController::class, 'signUp'],
    '~^users/(\d+)/activate/(.+)$~' => [\MyProject\Controllers\UsersController::class, 'activate'],
    '~^users/login$~' => [\MyProject\Controllers\UsersController::class, 'login'],
    '~^users/logout$~' => [\MyProject\Controllers\UsersController::class, 'logout'],
    '~^users/account$~' => [\MyProject\Controllers\UsersController::class, 'viewAccount'],
    '~^users/edit/nickname$~' => [\MyProject\Controllers\UsersController::class, 'editNickname'],
    '~^users/comments$~' => [\MyProject\Controllers\UsersController::class, 'viewCommentsManagement'],
    '~^articles/(\d+)/comments$~' => [\MyProject\Controllers\CommentsController::class, 'add'],
    '~^comments/(\d+)/edit$~' => [\MyProject\Controllers\CommentsController::class, 'edit'],
    '~^comments/(\d+)/delete$~' => [\MyProject\Controllers\CommentsController::class, 'delete'],
    '~^administration$~' => [\MyProject\Controllers\AdminsController::class, 'main'],
    '~^administration/articles$~' => [\MyProject\Controllers\AdminsController::class, 'viewArticlesManagement'],
    '~^administration/comments$~' => [\MyProject\Controllers\AdminsController::class, 'viewCommentsManagement'],
    '~^administration/site/name$~' => [\MyProject\Controllers\AdminsController::class, 'editSiteName'],
];