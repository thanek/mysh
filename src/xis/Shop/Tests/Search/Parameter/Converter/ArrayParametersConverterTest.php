<?php
namespace xis\Shop\Tests\Search\Parameter\Converter;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\Shop\Entity\Category;
use xis\Shop\Search\Parameter\Converter\ArrayParametersConverter;

class ArrayParametersConverterTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function shouldSetFiltersFromGivenArray()
    {
        $array = array('keyword' => 'foo', 'price_from' => 123);
        $categoryRepository = $this->prophesize('xis\Shop\Repository\CategoryRepository');
        $arrayParametersConverter = new ArrayParametersConverter($array, $categoryRepository->reveal());

        $filters = $arrayParametersConverter->getFilters();

        $this->assertSame(2, count($filters));
    }

    /**
     * @test
     */
    public function shouldCreateKeywordFilter()
    {
        $array = array('keyword' => 'foo');
        $categoryRepository = $this->prophesize('xis\Shop\Repository\CategoryRepository');
        $arrayParametersConverter = new ArrayParametersConverter($array, $categoryRepository->reveal());

        $filters = $arrayParametersConverter->getFilters();

        $this->assertSame('xis\Shop\Search\Filter\KeywordFilter', get_class($filters[0]));
    }

    /**
     * @test
     */
    public function shouldCreatePriceFromFilter()
    {
        $array = array('price_from' => 123.12);
        $categoryRepository = $this->prophesize('xis\Shop\Repository\CategoryRepository');
        $arrayParametersConverter = new ArrayParametersConverter($array, $categoryRepository->reveal());

        $filters = $arrayParametersConverter->getFilters();

        $this->assertSame('xis\Shop\Search\Filter\PriceFromFilter', get_class($filters[0]));
    }

    /**
     * @test
     */
    public function shouldCreatePriceToFilter()
    {
        $array = array('price_to' => 123.12);
        $categoryRepository = $this->prophesize('xis\Shop\Repository\CategoryRepository');
        $arrayParametersConverter = new ArrayParametersConverter($array, $categoryRepository->reveal());

        $filters = $arrayParametersConverter->getFilters();

        $this->assertSame('xis\Shop\Search\Filter\PriceToFilter', get_class($filters[0]));
    }

    /**
     * @test
     */
    public function shouldCreateCategoryFilter()
    {
        $array = array('category' => 123);
        $categoryRepository = $this->prophesize('xis\Shop\Repository\CategoryRepository');
        $categoryRepository->find(123)->willReturn(new Category());
        $arrayParametersConverter = new ArrayParametersConverter($array, $categoryRepository->reveal());

        $filters = $arrayParametersConverter->getFilters();

        $this->assertSame('xis\Shop\Search\Filter\CategoryFilter', get_class($filters[0]));
    }
}