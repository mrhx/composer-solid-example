<?php

namespace app\model;

/**
 * User interface
 */
interface UserInterface
{
    /**
     * @return integer
     */
    public function getId();

    /**
     * @param integer $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getCreated();

    /**
     * @param string $date
     * @return $this
     */
    public function setCreated($date);

    /**
     * @return string
     */
    public function getUpdated();

    /**
     * @param string $date
     * @return $this
     */
    public function setUpdated($date);

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param string $email
     * @return $this
     */
    public function setEmail($email);

    /**
     * @return string
     */
    public function getPassword();

    /**
     * @param string $password
     * @return $this
     */
    public function setPassword($password);

    /**
     * @return string
     */
    public function getCountry();

    /**
     * @param string $country
     * @return $this
     */
    public function setCountry($country);

    /**
     * @return string
     */
    public function getTimezone();

    /**
     * @param string $timezone
     * @return $this
     */
    public function setTimezone($timezone);
}
