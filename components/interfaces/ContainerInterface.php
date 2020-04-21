<?php

namespace components\interfaces;

interface ContainerInterface
{
    /**
     * @param string $name
     * @return mixed
     */
    public function get(string $name);

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool;
}
