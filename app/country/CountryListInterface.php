<?php

namespace app\country;

/**
 * The interface for getting the country list
 */
interface CountryListInterface
{
    /**
     * Get the country list
     * @return array "code" => "name"
     */
    public function getList();
}
