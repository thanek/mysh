<?php

namespace xis\ShopCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $paginator  = $this->get('knp_paginator');
        echo get_class($paginator);exit;
        $name = 'foo';
        return array('name' => $name);
    }
}
