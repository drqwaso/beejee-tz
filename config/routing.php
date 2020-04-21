<?php

use application\controllers\AuthController;
use application\controllers\TaskListController;

return [
    'routes' => [
        '/task/done' => [TaskListController::class, 'actionDone'],
        '/task/edit' => [TaskListController::class, 'actionEdit'],
        '/task/list' => [TaskListController::class, 'actionList'],
        '/signin' => [AuthController::class, 'actionSignIn'],
        '/signout' => [AuthController::class, 'actionSignOut'],
    ],
    'defaultRoute' => '/task/list',
];
