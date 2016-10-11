<?php

namespace app\validator;

/**
 * An abstraction for using external validators
 */
interface ValidatorFactoryInterface
{
    /**
     * @param array $data an array of data to validate
     * @return ValidatorInterface
     */
    public function createInstance(array $data);
}
