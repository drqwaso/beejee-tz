<?php

namespace components\interfaces;

interface AuthUserInterface
{
    /**
     * @return int
     */
    public function getId();

    /**
     * @return string
     */
    public function getLogin(): string;
}
