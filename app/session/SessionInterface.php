<?php

namespace app\session;

/**
 * Very simple session interface
 */
interface SessionInterface
{
    /**
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value);
}
