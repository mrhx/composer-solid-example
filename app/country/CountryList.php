<?php

namespace app\country;

use RuntimeException;

/**
 * Default country list implementation
 */
class CountryList implements CountryListInterface
{
    /**
     * @var string
     */
    protected $dataPath;

    /**
     * @var string
     */
    protected $locale;

    /**
     * @var array
     */
    private $data;

    /**
     * @param string $dataPath
     * @param string $locale
     */
    public function __construct($dataPath, $locale = 'en')
    {
        $this->dataPath = $dataPath;
        $this->locale = $locale;
    }

    /**
     * Get the country list
     * @return array "code" => "name"
     * @throws RuntimeException
     */
    public function getList()
    {
        if ($this->data === null) {
            $filePath = $this->dataPath . DIRECTORY_SEPARATOR . $this->locale . DIRECTORY_SEPARATOR . 'country.php';
            if (!file_exists($filePath)) {
                throw new RuntimeException("Locale '{$this->locale}' does not exist");
            }
            $this->data = require $filePath;
        }
        return $this->data;
    }
}
