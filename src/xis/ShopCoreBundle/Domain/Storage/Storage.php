<?php
namespace xis\ShopCoreBundle\Domain\Storage;

interface Storage
{
    /**
     * @return mixed
     */
    function generateId();

    /**
     * @param $id
     * @param $obj
     * @return null
     */
    function store($id, $obj);

    /**
     * @param $id
     * @return null
     */
    function clear($id);
} 