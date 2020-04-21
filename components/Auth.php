<?php

namespace components;

use components\interfaces\AuthUserInterface;
use components\interfaces\UserRepositoryInterface;

class Auth
{
    /** @var UserRepositoryInterface */
    private $userRepository;

    /**
     * Auth constructor.
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $password
     * @return bool|string
     */
    public function hashPassword(string $password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }

    /**
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verifyPassword(string $password, string $hash)
    {
        return password_verify($password, $hash);
    }

    /**
     * @param AuthUserInterface $user
     */
    public function grantAccess(AuthUserInterface $user)
    {
        $_SESSION['userId'] = $user->getId();
        $_SESSION['login'] = $user->getLogin();
    }

    /**
     * @return AuthUserInterface|null
     */
    public function getUser()
    {
        if (isset($_SESSION['login']) && isset($_SESSION['userId'])) {
            $user = $this->userRepository->getByLogin($_SESSION['login']);

            return $user && ($user->getId() == $_SESSION['userId']) ? $user : null;
        }

        return null;
    }

    public function signOut()
    {
        unset($_SESSION['userId'], $_SESSION['login']);
    }
}
