<?php

namespace application;

use application\controllers\AuthController;
use application\controllers\TaskListController;
use application\model\repository\TaskRepository;
use application\model\repository\UserRepository;
use application\model\forms\Signin;
use components\Auth;
use components\Config;
use components\db\MysqlConnection;

class Container extends \components\Container
{
    protected function init(Config $config)
    {
        parent::init($config);

        $this->definitions = array_replace($this->definitions, [
            Signin::class => [
                'arguments' => [
                    Auth::class,
                    UserRepository::class,
                ],
            ],
            TaskRepository::class => [
                'arguments' => [
                    MysqlConnection::class,
                ],
            ],
            UserRepository::class => [
                'arguments' => [
                    MysqlConnection::class,
                ],
            ],
            Auth::class => [
                'shared' => true,
                'arguments' => [
                    UserRepository::class,
                ],
            ],
            TaskListController::class => [
                'arguments' => [
                    $this
                ],
            ],
            AuthController::class => [
                'arguments' => [
                    $this
                ],
            ],
        ]);
    }
}
