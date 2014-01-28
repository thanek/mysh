<?php
namespace xis\ShopCoreBundle\Tests\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Persisters\BasicEntityPersister;
use Doctrine\ORM\UnitOfWork;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;

class AbstractRepositoryTestCase extends ProphecyTestCase
{
    /** @var EntityManager | ObjectProphecy */
    protected $em;
    /** @var ClassMetadata | ObjectProphecy $metaData */
    protected $metadata;
    /** @var BasicEntityPersister | ObjectProphecy $persister */
    protected $persister;

    public function setup()
    {
        parent::setup();
        $this->metaData = $this->prophesize('\Doctrine\ORM\Mapping\ClassMetadata');
        $this->em = $this->prophesize('\Doctrine\ORM\EntityManager');
        $unitOfWork = $this->prophesize('\Doctrine\ORM\UnitOfWork');
        $this->em->getUnitOfWork()->willReturn($unitOfWork);
        $this->persister = $this->prophesize('\Doctrine\ORM\Persisters\BasicEntityPersister');

        $this->metaData->name = 'someClass';
        $unitOfWork->getEntityPersister('someClass')->willReturn($this->persister);
    }
}