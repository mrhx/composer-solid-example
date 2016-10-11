<?php

namespace app\model;

/**
 * User factory interface
 */
interface UserFactoryInterface
{
    /**
     * @return UserInterface
     */
    public function createInstance();
}
