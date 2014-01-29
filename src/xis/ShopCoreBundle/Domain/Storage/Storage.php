<?php
namespace xis\ShopCoreBundle\Domain\Storage;

interface Storage
{
    /**
     * @param $obj
     * @return null
     */
    function store($obj);

    /**
     * @return mixed
     */
    function get();

    /**
     * @return null
     */
    function clear();
} 