<?php

namespace app\view;

/**
 * Very basic view interface
 */
interface ViewInterface
{
    /**
     * Render a view
     * @param string $viewName
     * @param array $params
     * @return string
     */
    public function render($viewName, array $params = []);
}
