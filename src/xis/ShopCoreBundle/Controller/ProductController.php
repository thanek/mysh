<?php
namespace xis\ShopCoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Repository\ProductRepository;
use xis\Shop\Search\Builder\SearchBuilder;
use xis\Shop\Search\Service\AllProductsSearch;
use xis\Shop\Search\Service\InCategorySearch;
use xis\ShopCoreBundle\Search\Parameter\Converter\RequestParametersConverter;

/**
 * @Route(service="xis.shop.controller.product")
 */
class ProductController
{
    /** @var HttpFacade */
    private $http;
    /** @var ProductRepository */
    private $productRepository;
    /** @var CategoryRepository */
    private $categoryRepository;
    /** @var SearchBuilder */
    private $searchBuilder;

    function __construct(
        HttpFacade $http, ProductRepository $productRepository, CategoryRepository $categoryRepository,
        SearchBuilder $searchBuilder)
    {
        $this->http = $http;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->searchBuilder = $searchBuilder;
    }

    /**
     * @Route("/products_all",name="products_all")
     * @Template("xisShopCoreBundle:Product:listing.html.twig")
     */
    public function allAction()
    {
        $page = $this->getQueryParameter('page', 1);
        $search = $this->searchBuilder
            ->with(new RequestParametersConverter($this->http->getRequest()))
            ->using(new AllProductsSearch());
        $pager = $search->getResults(60, $page);
        $filters = $search->getFilters();

        return array('pager' => $pager, 'filters' => $filters, 'title' => 'All products');
    }

    /**
     * @Route("/{slug},c,{id}",name="category")
     * @Template("xisShopCoreBundle:Product:listing.html.twig")
     */
    public function browseCategoryAction($slug, $id)
    {
        $page = $this->getQueryParameter('page', 1);
        $category = $this->categoryRepository->find($id);
        if (!$category) {
            $this->http->addFlashMessage('notice', 'No such category');
            return $this->http->redirect('home');
        }

        $pager = $this->searchBuilder
            ->with(new RequestParametersConverter($this->http->getRequest()))
            ->using(new InCategorySearch($category))
            ->getResults(60, $page);
        $filters = $this->searchBuilder->getFilters();

        return array('pager' => $pager, 'filters' => $filters, 'title' => $category->getName());
    }

    /**
     * @param string $key
     * @param mixed|null $defaultValue
     * @return mixed
     */
    protected function getQueryParameter($key, $defaultValue = null)
    {
        return $this->http->getRequestParam($key, $defaultValue);
    }
}
