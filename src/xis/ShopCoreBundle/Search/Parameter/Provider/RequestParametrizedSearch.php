<?php
namespace xis\ShopCoreBundle\Search\Parameter\Provider;

use Symfony\Component\HttpFoundation\Request;
use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Search\Parameter\Converter\ParametersConverter;
use xis\Shop\Search\Parameter\Provider\SearchParameterProvider;
use xis\ShopCoreBundle\Search\Parameter\Converter\RequestParametersConverter;

class RequestParametrizedSearch implements SearchParameterProvider
{
    /** @var Request */
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @return ParametersConverter
     */
    public function getParamsConverter(CategoryRepository $categoryRepository)
    {
        return new RequestParametersConverter($this->request, $categoryRepository);
    }
}