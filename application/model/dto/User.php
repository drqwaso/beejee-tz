<?php

namespace application\model\dto;

use components\interfaces\AuthUserInterface;

class User implements AuthUserInterface
{
    /** @var int */
    private $id;

    /** @var string */
    private $username;

    /** @var string */
    private $login;

    /** @var string */
    private $pass;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername(string $username): User
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @param string $login
     * @return User
     */
    public function setLogin(string $login): User
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @param string $pass
     * @return User
     */
    public function setPass(string $pass): User
    {
        $this->pass = $pass;

        return $this;
    }
}
