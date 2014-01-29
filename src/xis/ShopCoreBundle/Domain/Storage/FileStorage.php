<?php
namespace xis\ShopCoreBundle\Domain\Storage;

class FileStorage implements Storage
{
    /** @var string */
    private $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @param $obj
     * @return null
     */
    function store($obj)
    {
        $fh = fopen($this->filename, 'w');
        fwrite($fh, serialize($obj));
        fclose($fh);
    }

    /**
     * @return mixed
     */
    function get()
    {
        $obj = null;
        $fh = @fopen($this->filename, 'r');
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
        unlink($this->filename);
    }
}