<?php
namespace xis\ShopCoreBundle\Tests\Repository\Pager;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\ShopCoreBundle\Repository\Pager\DoctrinePagerFactory;

class DoctrinePagerFactoryTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function getPagerShouldCreatePagerFromBuilder()
    {
        $queryBuilder = $this->prophesize('Doctrine\ORM\QueryBuilder');

        $factory = new DoctrinePagerFactory();
        $pager = $factory->getPager($queryBuilder->reveal());

        $this->assertEquals(
            'xis\ShopCoreBundle\Repository\Pager\PagerfantaDoctrinePager', get_class($pager)
        );
    }
} 