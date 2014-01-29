<?php
namespace xis\ShopCoreBundle\Domain\Storage;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionStorage implements Storage
{
    /** @var string */
    private $key;
    /** @var SessionInterface */
    private $session;

    function __construct($key, SessionInterface $session)
    {
        $this->key = $key;
        $this->session = $session;
    }

    /**
     * @return mixed
     */
    public function get()
    {
        return $this->session->get($this->key);
    }

    /**
     * @param $obj
     * @return null
     */
    function store($obj)
    {
        $this->session->set($this->key, $obj);
    }

    /**
     * @return null
     */
    function clear()
    {
        $this->session->remove($this->key);
    }
}