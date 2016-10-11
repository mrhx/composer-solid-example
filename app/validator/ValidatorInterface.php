<?php

namespace app\validator;

/**
 * An abstraction for using external validators
 */
interface ValidatorInterface
{
    /**
     * @return boolean
     */
    public function validate();

    /**
     * @return array
     */
    public function getErrors();

    /**
     * @param string|array $fieldName
     * @return void
     */
    public function required($fieldName);

    /**
     * @param string|array $fieldName
     * @param integer $minLength
     * @param integer $maxLength
     * @return void
     */
    public function lengthBetween($fieldName, $minLength, $maxLength);

    /**
     * @param string|array $fieldName
     * @return void
     */
    public function email($fieldName);

    /**
     * @param string|array $fieldName
     * @param integer $maxLength
     * @return void
     */
    public function lengthMax($fieldName, $maxLength);

    /**
     * @param string|array $fieldName
     * @param integer $minLength
     * @return void
     */
    public function lengthMin($fieldName, $minLength);

    /**
     * @param string|array $fieldName
     * @param string $regexp
     * @return void
     */
    public function regexp($fieldName, $regexp);

    /**
     * @param string|array $fieldName
     * @param array $array
     * @return void
     */
    public function in($fieldName, array $array);

    /**
     * @param string|array $fieldName
     * @param array $array
     * @return void
     */
    public function inKeys($fieldName, array $array);
}
