<?php

namespace app\repository;

use app\model\UserInterface;
use app\model\UserFactoryInterface;
use FluentPDO;

/**
 * User repository
 */
class UserRepository implements UserRepositoryInterface
{
    /**
     * Users table
     */
    const TABLE = 'user';

    /**
     * @var FluentPDO
     */
    protected $fpdo;

    /**
     * @var UserFactoryInterface
     */
    protected $userFactory;

    /**
     * @param FluentPDO $fpdo
     * @param UserFactoryInterface $userFactory
     */
    public function __construct(FluentPDO $fpdo, UserFactoryInterface $userFactory)
    {
        $this->fpdo = $fpdo;
        $this->userFactory = $userFactory;
    }

    /**
     * @param UserInterface $user
     * @return void
     */
    public function save(UserInterface $user)
    {
        $data = [
            'created' => $user->getCreated(),
            'updated' => $user->getUpdated(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
            'country' => $user->getCountry(),
            'timezone' => $user->getTimezone(),
        ];

        if ($user->getId()) {
            $result = $this->fpdo
                ->update(self::TABLE, $data, $user->getId())
                ->execute();
        } else {
            $id = $this->fpdo
                ->insertInto(self::TABLE, $data)
                ->execute();

            $user->setId($id);
        }
    }

    /**
     * @param string $email
     * @return UserInterface|false
     */
    public function findByEmail($email)
    {
        $data = $this->fpdo
            ->from(self::TABLE)
            ->where('email', $email)
            ->limit(1)
            ->fetch();

        if (!$data) {
            return false;
        }

        $user = $this->userFactory->createInstance();

        $user->setId($data['id']);
        $user->setCreated($data['created']);
        $user->setUpdated($data['updated']);
        $user->setName($data['name']);
        $user->setEmail($data['email']);
        $user->setPassword($data['password']);
        $user->setCountry($data['country']);
        $user->setTimezone($data['timezone']);

        return $user;
    }
}
