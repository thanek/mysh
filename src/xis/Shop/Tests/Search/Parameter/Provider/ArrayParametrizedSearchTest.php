<?php
namespace xis\Shop\Tests\Search\Parameter\Provider;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\Shop\Search\Parameter\Converter\ArrayParametersConverter;
use xis\Shop\Search\Parameter\Provider\ArrayParametrizedSearch;

class ArrayParametrizedSearchTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function shouldProvideArrayParametersConverter()
    {
        $array = array('keyword' => 'foo', 'price_from' => 123);
        $categoryRepository = $this->prophesize('xis\Shop\Repository\CategoryRepository');

        $arrayParametrizedSearch = new ArrayParametrizedSearch($array);
        $output = $arrayParametrizedSearch->getParamsConverter($categoryRepository->reveal());

        $this->assertSame('xis\Shop\Search\Parameter\Converter\ArrayParametersConverter', get_class($output));
        $this->assertSame(2, count($output->getFilters()));
    }
}
