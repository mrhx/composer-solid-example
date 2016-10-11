<?php

namespace app\validator;

use Valitron\Validator;

/**
 * Support of Valitron validator library
 * @link https://github.com/vlucas/valitron
 */
class ValitronValidator implements ValidatorInterface
{
    /**
     * @var Validator
     */
    protected $instance;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->instance = new Validator($data);
    }

    /**
     * @return boolean
     */
    public function validate()
    {
        return $this->instance->validate();
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->instance->errors();
    }

    /**
     * @param string|array $fieldName
     * @return void
     */
    public function required($fieldName)
    {
        $this->instance->rule('required', $fieldName);
    }

    /**
     * @param string|array $fieldName
     * @param integer $minLength
     * @param integer $maxLength
     * @return void
     */
    public function lengthBetween($fieldName, $minLength, $maxLength)
    {
        $this->instance->rule('lengthBetween', $fieldName, $minLength, $maxLength);
    }

    /**
     * @param string|array $fieldName
     * @return void
     */
    public function email($fieldName)
    {
        $this->instance->rule('email', $fieldName);
    }

    /**
     * @param string|array $fieldName
     * @param integer $maxLength
     * @return void
     */
    public function lengthMax($fieldName, $maxLength)
    {
        $this->instance->rule('lengthMax', $fieldName, $maxLength);
    }

    /**
     * @param string|array $fieldName
     * @param integer $minLength
     * @return void
     */
    public function lengthMin($fieldName, $minLength)
    {
        $this->instance->rule('lengthMin', $fieldName, $minLength);
    }

    /**
     * @param string|array $fieldName
     * @param string $regexp
     * @return void
     */
    public function regexp($fieldName, $regexp)
    {
        $this->instance->rule('regex', $fieldName, $regexp);
    }

    /**
     * @param string|array $fieldName
     * @param array $array
     * @return void
     */
    public function in($fieldName, array $array)
    {
        $this->instance->rule('in', $fieldName, $array);
    }

    /**
     * @param string|array $fieldName
     * @param array $array
     * @return void
     */
    public function inKeys($fieldName, array $array)
    {
        $this->instance->rule('in', $fieldName, array_keys($array));
    }
}
