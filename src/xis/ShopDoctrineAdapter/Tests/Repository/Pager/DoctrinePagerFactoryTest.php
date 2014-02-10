<?php
namespace xis\ShopDoctrineAdapter\Tests\Repository\Pager;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\ShopDoctrineAdapter\Repository\Pager\DoctrinePagerFactory;

class DoctrinePagerFactoryTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function shouldCreatePagerFromBuilder()
    {
        $queryBuilder = $this->prophesize('Doctrine\ORM\QueryBuilder');

        $factory = new DoctrinePagerFactory();
        $pager = $factory->getPager($queryBuilder->reveal());

        $this->assertEquals(
            'xis\Shop\Repository\Pager\PagerfantaPager', get_class($pager)
        );
    }
} 