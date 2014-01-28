<?php
namespace xis\ShopCoreBundle\Tests\Controller;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\ShopCoreBundle\Controller\DefaultController;

class DefaultControllerTest extends ProphecyTestCase
{
    public function testIndexAction()
    {
        $c = new DefaultController();
        $output = $c->indexAction();
        $this->assertEquals(array('name' => 'foo'), $output);
    }
} 