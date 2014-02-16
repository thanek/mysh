<?php
namespace xis\ShopCoreBundle\Tests\Search\Provider;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpFoundation\Request;
use xis\Shop\Repository\CategoryRepository;
use xis\ShopCoreBundle\Search\Parameter\Provider\RequestParametrizedSearch;

class RequestParametrizedSearchTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function shouldCreateParametersConverter()
    {
        /** @var Request | ObjectProphecy $request */
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        /** @var CategoryRepository | ObjectProphecy $categoryRepository */
        $categoryRepository = $this->prophesize('xis\Shop\Repository\CategoryRepository');
        $requestParametrizedSearch = new RequestParametrizedSearch($request->reveal());

        $converter = $requestParametrizedSearch->getParamsConverter($categoryRepository->reveal());

        $this->assertNotNull($converter);
        $this->assertInstanceOf('xis\ShopCoreBundle\Search\Parameter\Converter\RequestParametersConverter', $converter);
    }
} 