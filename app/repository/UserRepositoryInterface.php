<?php

namespace app\repository;

use app\model\UserInterface;

/**
 * User repository interface
 */
interface UserRepositoryInterface
{
    /**
     * @param UserInterface $user
     * @return void
     */
    public function save(UserInterface $user);

    /**
     * @param string $email
     * @return UserInterface|false
     */
    public function findByEmail($email);
}
