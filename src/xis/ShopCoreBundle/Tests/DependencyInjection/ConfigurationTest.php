<?php
namespace xis\ShopCoreBundle\Tests\DependencyInjection;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\ShopCoreBundle\DependencyInjection\Configuration;

class ConfigurationTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function shouldReturnBuilder()
    {
        $configuration = new Configuration();

        $builder = $configuration->getConfigTreeBuilder();
        $this->assertEquals('Symfony\Component\Config\Definition\Builder\TreeBuilder', get_class($builder));

        $tree = $builder->buildTree();
        $this->assertEquals('xis_shop_core', $tree->getName());
    }
}