<?php
namespace xis\ShopCoreBundle\Domain\Storage;

class FileStorage implements Storage
{
    /**
     * @param $obj
     * @return null
     */
    function store($obj)
    {
        $fh = fopen('/tmp/cart', 'w');
        fwrite($fh, serialize($obj));
        fclose($fh);
    }

    /**
     * @return mixed
     */
    function get()
    {
        $obj = null;
        $fh = @fopen('/tmp/cart', 'r');
        if ($fh) {
            $str = fgets($fh);
            fclose($fh);
            $obj = unserialize($str);
        }
        return $obj;
    }

    /**
     * @return null
     */
    function clear()
    {
        unlink('/tmp/cart');
    }
}