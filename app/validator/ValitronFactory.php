<?php

namespace app\validator;

/**
 * Support of Valitron validator library
 * @link https://github.com/vlucas/valitron
 */
class ValitronFactory implements ValidatorFactoryInterface
{
    /**
     * @param array $data an array of data to validate
     * @return ValidatorInterface
     */
    public function createInstance(array $data)
    {
        return new ValitronValidator($data);
    }
}
