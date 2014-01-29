<?php
namespace xis\ShopCoreBundle\Domain\Storage;

class SessionStorage implements Storage
{
    /** @var string */
    private $prefix;

    function __construct($prefix)
    {
        $this->prefix = $prefix;
    }


    /**
     * @return null
     */
    function generateId()
    {
        $this->ensureSessionStarted();
        return session_id();
    }

    /**
     * @param $id
     * @param $obj
     * @return null
     */
    function store($id, $obj)
    {
        $_SESSION[$this->getKey($id)] = $obj;
    }

    /**
     * @param $id
     * @return null
     */
    function clear($id)
    {
        unset($_SESSION[$this->getKey($id)]);

    }

    protected function ensureSessionStarted()
    {
        if (session_id() == null) {
            session_start();
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getKey($id)
    {
        return $this->prefix . '::' . $id;
    }
}