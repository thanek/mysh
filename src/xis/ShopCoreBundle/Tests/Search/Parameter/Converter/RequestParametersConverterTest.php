<?php
namespace xis\ShopCoreBundle\Tests\Search\Parameter\Converter;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpFoundation\Request;
use xis\Shop\Entity\Category;
use xis\Shop\Repository\CategoryRepository;
use xis\ShopCoreBundle\Search\Parameter\Converter\RequestParametersConverter;

class RequestParametersConverterTest extends ProphecyTestCase
{
    /** @var Request|ObjectProphecy */
    private $request;
    /** @var CategoryRepository|ObjectProphecy */
    private $categoryRepository;
    /** @var RequestParametersConverter */
    private $requestParameterConverter;

    public function setup()
    {
        parent::setup();
        $this->request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $this->categoryRepository = $this->prophesize('xis\Shop\Repository\CategoryRepository');
        $this->requestParameterConverter = new RequestParametersConverter($this->request->reveal());
    }

    /**
     * @test
     */
    public function shouldCreateFiltersWithKeyword()
    {
        $this->request->get(Argument::any())->willReturn(null);
        $this->request->get('keyword')->willReturn('foo');

        $filters = $this->requestParameterConverter->getFilters($this->categoryRepository->reveal());

        $this->assertSame(1, count($filters));
        $this->assertSame('xis\Shop\Search\Filter\KeywordFilter', get_class($filters[0]));
    }

    /**
     * @test
     */
    public function shouldCreateFiltersWithPriceFrom()
    {
        $this->request->get(Argument::any())->willReturn(null);
        $this->request->get('price_from')->willReturn(123.20);

        $filters = $this->requestParameterConverter->getFilters($this->categoryRepository->reveal());

        $this->assertSame(1, count($filters));
        $this->assertSame('xis\Shop\Search\Filter\PriceFromFilter', get_class($filters[0]));
    }

    /**
     * @test
     */
    public function shouldCreateFiltersWithPriceTo()
    {
        $this->request->get(Argument::any())->willReturn(null);
        $this->request->get('price_to')->willReturn(345.60);

        $filters = $this->requestParameterConverter->getFilters($this->categoryRepository->reveal());

        $this->assertSame(1, count($filters));
        $this->assertSame('xis\Shop\Search\Filter\PriceToFilter', get_class($filters[0]));
    }

    /**
     * @test
     */
    public function shouldCreateFiltersWithCategory()
    {
        $category = new Category();
        $this->categoryRepository->find(123)->willReturn($category);
        $this->request->get(Argument::any())->willReturn(null);
        $this->request->get('category')->willReturn(123);

        $filters = $this->requestParameterConverter->getFilters($this->categoryRepository->reveal());

        $this->assertSame(1, count($filters));
        $this->assertSame('xis\Shop\Search\Filter\CategoryFilter', get_class($filters[0]));
    }

    /**
     * @test
     */
    public function shouldCreateFiltersWithMultipleParameters()
    {
        $this->request->get(Argument::any())->willReturn(null);
        $this->request->get('keyword')->willReturn('foo');
        $this->request->get('price_to')->willReturn(123.23);

        $filters = $this->requestParameterConverter->getFilters($this->categoryRepository->reveal());

        $this->assertSame(2, count($filters));
        $this->assertSame('xis\Shop\Search\Filter\KeywordFilter', get_class($filters[0]));
        $this->assertSame('xis\Shop\Search\Filter\PriceToFilter', get_class($filters[1]));
    }
}