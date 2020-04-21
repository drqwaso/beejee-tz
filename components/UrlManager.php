<?php

namespace components;

class UrlManager
{
    /** @var array */
    private $urlParams;

    /** @var string */
    private $path;

    /**
     * ListManager constructor.
     * @param string $url
     * @param array|null $urlParams
     */
    public function __construct(string $path, array $urlParams = [])
    {
        $this->urlParams = $urlParams;
        $this->path = $path;
    }

    /**
     * @param array $urlParams
     * @return string
     */
    public function getUrl(array $urlParams): string
    {
        $query = $this->getQueryString(array_replace($this->urlParams, $urlParams));

        return $this->path . ($query ? '?' . $query : '');
    }

    /**
     * @param array $params
     * @return string
     */
    private function getQueryString(array $params): string
    {
        $query = [];

        foreach ($params as $param => $value) {
            if ($value) {
                $query[] = $param . '=' . $value;
            }
        }

        return implode('&', $query);
    }
}
