<?php
namespace xis\Shop\Tests\Repository\Pager;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\Shop\Repository\Pager\DoctrinePagerFactory;

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