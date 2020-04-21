<?php

namespace application\controllers;

use application\Container;
use application\model\forms\Signin;
use components\Auth;
use components\Request;
use components\View;

class AuthController
{
    /** @var Container */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function actionSignIn()
    {
        $auth = $this->container->get(Auth::class);
        $request = $this->container->get(Request::class);

        if ($auth->getUser()) {
            $request->redirect('/');
        }

        /** @var Signin $signin */
        $signin = $this->container->get(Signin::class);

        if ($request->isPost()) {
            $signin->setLogin($_POST['login']);
            $signin->setPass($_POST['pass']);
            if ($signin->validate()) {

                $auth->grantAccess($signin->getUser());
                $request->redirect('/');
            }
        }

        $view = $this->container->get(View::class);
        $view->setLayout('layouts/auth.layout.php');
        $view->render('main/signin.php', ['signin' => $signin]);
    }

    public function actionSignOut()
    {
        /** @var Request $request */
        $request = $this->container->get(Request::class);
        /** @var Auth $auth */
        $auth = $this->container->get(Auth::class);

        $auth->signOut();
        $request->redirect('/');
    }
}
