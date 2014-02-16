<?php
namespace xis\ShopCoreBundle\Search\Parameter\Converter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Search\Filter\Filter;
use xis\Shop\Search\Filter\CategoryFilter;
use xis\Shop\Search\Filter\KeywordFilter;
use xis\Shop\Search\Filter\PriceFromFilter;
use xis\Shop\Search\Filter\PriceToFilter;
use xis\Shop\Search\Parameter\Converter\ParametersConverter;

class RequestParametersConverter implements ParametersConverter
{
    /** @var Request */
    private $request;
    /** @var CategoryRepository */
    private $categoryRepository;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @return Filter[]
     */
    function getFilters()
    {
        $request = $this->request;
        $ret = array();
        if ($request->get('keyword')) {
            $ret[] = new KeywordFilter($request->get('keyword'));
        }
        if ($request->get('price_from')) {
            $ret[] = new PriceFromFilter($request->get('price_from'));
        }
        if ($request->get('price_to')) {
            $ret[] = new PriceToFilter($request->get('price_to'));
        }
        if ($request->get('category')) {
            $category = $this->categoryRepository->find($request->get('category'));
            $ret[] = new CategoryFilter($category);
        }
        return $ret;
    }

    public function setCategoryRepository(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
}