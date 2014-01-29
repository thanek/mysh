<?php
namespace xis\ShopCoreBundle\Tests\Domain\Repository\Pager;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\ShopCoreBundle\Domain\Repository\Pager\DoctrinePagerFactory;

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
            'xis\ShopCoreBundle\Domain\Repository\Pager\PagerfantaPager', get_class($pager)
        );
    }
} 