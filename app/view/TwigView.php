<?php

namespace app\view;

use app\country\CountryListInterface;
use Twig_Environment;
use Twig_Extensions_Extension_I18n;
use Twig_Loader_Filesystem;
use Twig_SimpleFilter;

/**
 * Basic Twig support
 */
class TwigView implements ViewInterface
{
    /**
     * @var string
     */
    protected $viewsPath;

    /**
     * @var string
     */
    protected $tmpPath;

    /**
     * @var CountryListInterface
     */
    protected $countryList;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @param string $viewsPath
     * @param string $tmpPath
     * @param CountryListInterface $countryList
     */
    public function __construct($viewsPath, $tmpPath, CountryListInterface $countryList)
    {
        $this->viewsPath = $viewsPath;
        $this->tmpPath = $tmpPath;
        $this->countryList = $countryList;
    }

    /**
     * Render a view
     * @param string $viewName
     * @param array $params
     * @return string
     */
    public function render($viewName, array $params = [])
    {
        return $this->getTwig()->render($viewName . '.twig.html', $params);
    }

    /**
     * Get a Twig instance
     * @return Twig_Environment
     */
    protected function getTwig()
    {
        if ($this->twig === null) {
            $loader = new Twig_Loader_Filesystem($this->viewsPath);
            $this->twig = new Twig_Environment($loader, [
                'cache' => $this->tmpPath,
                'auto_reload' => true,
                'autoescape' => true,
                'strict_variables' => false
            ]);
            $this->twig->addExtension(new Twig_Extensions_Extension_I18n());

            $this->twig->addFilter(new Twig_SimpleFilter('gravatarHash', function ($email) {
                return md5(strtolower(trim($email)));
            }));

            $this->twig->addFilter(new Twig_SimpleFilter('countryName', function ($countryCode) {
                static $list;
                if ($list === null) {
                    $list = $this->countryList->getList();
                }
                return isset($list[$countryCode]) ? $list[$countryCode] : $countryCode;
            }));
        }
        return $this->twig;
    }
}
