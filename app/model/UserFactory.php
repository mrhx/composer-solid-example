<?php

namespace app\model;

/**
 * User factory
 */
class UserFactory implements UserFactoryInterface
{
    /**
     * @return UserInterface
     */
    public function createInstance()
    {
        return new User();
    }
}
