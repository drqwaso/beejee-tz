<?php

namespace application\model\repository;

use application\model\dto\User;
use components\db\AbstractDao;
use components\interfaces\AuthUserInterface;
use components\interfaces\UserRepositoryInterface;

class UserRepository extends AbstractDao implements UserRepositoryInterface
{
    /**
     * @param string $username
     * @return bool
     */
    public function existsByLogin(string $username): bool
    {
        $stmt = $this->query(
            'select count(t.login) from users t where t.login = :login',
            ['login' => $username]
        );

        return (bool) $stmt->fetchColumn();
    }

    /**
     * @param string $username
     * @return AuthUserInterface|null
     */
    public function getByLogin(string $username): ?AuthUserInterface
    {
        $stmt = $this->query(
            'select * from users t where t.login = :login',
            ['login' => $username]
        );

        $data = $stmt->fetch();

        return $data ? $this->hidrateObject($data) : null;
    }

    /**
     * @param array $data
     * @return User
     */
    public function hidrateObject(array $data)
    {
        $user = new User();

        return $user->setId($data['id'])
            ->setLogin($data['login'])
            ->setPass($data['pass'])
            ->setUsername($data['username']);
    }
}
