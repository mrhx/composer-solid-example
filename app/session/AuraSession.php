<?php

namespace app\session;

use Aura\Session\SessionFactory;

/**
 * Session based on aura/session
 * @link https://packagist.org/packages/aura/session
 */
class AuraSession implements SessionInterface
{
    /**
     * @var array
     */
    protected $cookie;

    /**
     * @var \Aura\Session\Segment
     */
    private $segment;

    /**
     * @param array $cookie
     */
    public function __construct(array $cookie)
    {
        $this->cookie = $cookie;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        return $this->getSessionSegment()->get($key);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function set($key, $value)
    {
        $this->getSessionSegment()->set($key, $value);
    }

    /**
     * @return \Aura\Session\Segment
     */
    protected function getSessionSegment()
    {
        if ($this->segment === null) {
            $sessionFactory = new SessionFactory();
            $session = $sessionFactory->newInstance($this->cookie);
            $this->segment = $session->getSegment('app');
        }
        return $this->segment;
    }
}
