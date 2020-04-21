<?php

namespace components;

class Controller
{
    /** @var View */
    private $view;

    /**
     * Controller constructor.
     * @param View $view
     */
    public function __construct(View $view)
    {
        $this->view = $view;
    }

    /**
     * @param string|null $message
     */
    public function actionNotFound(string $message = null)
    {
        header("HTTP/1.0 404 Not Found");
        $this->view->renderPart('main/defaultMessage.php', compact('message'));
    }

    /**
     * @param string|null $message
     */
    public function actionForbidden(string $message = null)
    {
        header('HTTP/1.0 403 Forbidden');
        $this->view->renderPart('main/defaultMessage.php', compact('message'));
    }
}
