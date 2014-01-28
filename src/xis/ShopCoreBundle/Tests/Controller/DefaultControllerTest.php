<?php
namespace xis\ShopCoreBundle\Tests\Controller;

use xis\ShopCoreBundle\Controller\DefaultController;

class DefaultControllerTest extends AbstractControllerTestCase
{
    public function testIndexAction()
    {
        $c = new DefaultController();
        $output = $c->indexAction();
        $this->assertEquals(array('name' => 'foo'), $output);
    }
} 