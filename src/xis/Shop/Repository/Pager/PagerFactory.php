<?php
namespace xis\Shop\Repository\Pager;

interface PagerFactory
{
    /**
     * @param $arg
     * @return Pager
     */
    function getPager($arg);
} 