<?php

namespace application\model\forms;

use application\model\dto\User;
use application\model\repository\UserRepository;
use components\Auth;
use components\interfaces\ValidableInterface;
use components\Validation;
use components\ValidationTrait;

class Signin implements ValidableInterface
{
    use ValidationTrait;

    private $user;

    /** @var string */
    private $login;

    /** @var string */
    private $pass;

    /** @var Auth */
    private $auth;

    /** @var UserRepository */
    private $userRepository;

    /**
     * Signin constructor.
     * @param Auth $auth
     * @param UserRepository $userRepository
     */
    public function __construct(Auth $auth, UserRepository $userRepository)
    {
        $this->auth = $auth;
        $this->userRepository = $userRepository;
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function validate(): bool
    {
        $validation = new Validation($this);
        $validation->required('login', $this->login)
            ->required('pass', $this->pass)
            ->alnum('pass', $this->pass)
            ->lenght('pass', $this->pass, null, 20)
            ->alnum('login', $this->login);

        if ($this->hasErrors()) {
            return false;
        }

        /** @var User $user */
        $user = $this->getUser();

        if (!$user || !$this->auth->verifyPassword($this->pass, $user->getPass())) {
            $this->addError('all', 'Неверное имя пользователя или пароль');
            return false;
        }

        return true;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @param string $login
     * @return Signin
     */
    public function setLogin(string $login): Signin
    {
        $this->login = $login;

        return $this;
    }

    /**
     * @return string
     */
    public function getPass(): string
    {
        return $this->pass;
    }

    /**
     * @param string $pass
     * @return Signin
     */
    public function setPass(string $pass): Signin
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * @return \components\interfaces\AuthUserInterface|null
     */
    public function getUser()
    {
        if (!$this->user) {
            $this->user = $this->userRepository->getByLogin($this->login);
        }

        return $this->user;
    }
}
