<?php

namespace components;

class Request
{
    private $requestUri;

    public function getRequestUri()
    {
        if (!$this->requestUri && isset($_SERVER['REQUEST_URI'])) {
            $uriComponents = parse_url($_SERVER['REQUEST_URI']);
            $this->requestUri = $uriComponents['path'];
        }

        return $this->requestUri;
    }

    public function paramsGet($paramName = null, $defaultValue = null)
    {
        if ($paramName) {
            return isset($_GET[$paramName]) ? $_GET[$paramName] : $defaultValue;
        }

        return $_GET;
    }

    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
            && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    public function isPost()
    {
        return isset($_SERVER['REQUEST_METHOD']) && !strcasecmp($_SERVER['REQUEST_METHOD'], 'POST');
    }

    public function redirect(string $url, ?string $message = null, $statusCode = 302)
    {
        if ($message) {
            $_SESSION['app.message'] = $message;
        }

        header('Location: ' . $url, true, $statusCode);
        exit;
    }

    public function flushMessage()
    {
        $message = $_SESSION['app.message'] ?? null;
        unset($_SESSION['app.message']);

        return $message;
    }

    public function hasMessage()
    {
        return isset($_SESSION['app.message']);
    }

    public function saveBackUrl()
    {
        $_SESSION['app.backurl'] = $_SERVER['HTTP_REFERER'] ?? null;
    }

    public function getBackUrl(): ?string
    {
        return $_SESSION['app.backurl'] ?? null;
    }

    public function flushBackUrl(): ?string
    {
        $backurl = $_SESSION['app.backurl'] ?? null;
        unset($_SESSION['app.backurl']);

        return $backurl;
    }
}
