<?php

namespace components\interfaces;

interface UserRepositoryInterface
{
    /**
     * @param string $login
     * @return AuthUserInterface|null
     */
    public function getByLogin(string $login): ?AuthUserInterface;
}
