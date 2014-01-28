<?php
namespace xis\ShopCoreBundle\Tests\Controller;


use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityRepository;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\DependencyInjection\Container;

class AbstractControllerTestCase extends ProphecyTestCase
{
    /** @var Registry | ObjectProphecy $doctrine */
    protected $doctrine;
    /** @var Container | ObjectProphecy $container */
    protected $container;

    public function setup()
    {
        parent::setup();

        $this->doctrine = $this->prophesize('Doctrine\Bundle\DoctrineBundle\Registry');

        $this->container = $this->prophesize('Symfony\Component\DependencyInjection\Container');
        $this->container->has('doctrine')->willReturn(1);
        $this->container->get('doctrine')->willReturn($this->doctrine);
    }

    /**
     * @param $repoClass
     * @param $entityClass
     * @return EntityRepository|ObjectProphecy
     */
    protected function getRepoMock($repoClass, $entityClass)
    {
        /** @var EntityRepository | ObjectProphecy $theRepo */
        $theRepo = $this->prophesize($repoClass);
        $this->doctrine->getRepository($entityClass)->willReturn($theRepo);

        return $theRepo;
    }
} 