<?php
namespace xis\ShopCoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Repository\ProductRepository;

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

    function __construct(HttpFacade $http, ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->http = $http;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Route("/products_all",name="products_all")
     * @Template("xisShopCoreBundle:Product:listing.html.twig")
     */
    public function allAction()
    {
        $page = $this->getQueryParameter('page', 1);
        $pager = $this->productRepository->getProducts(60, $page);

        return array('pager' => $pager, 'title' => 'All products');
    }

    /**
     * @Route("/{slug},c,{id}", name="category", requirements={"slug"="[^/,]*"})
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

        $pager = $this->productRepository->getProductsFromCategory($category, 60, $page);
        return array('pager' => $pager, 'title' => $category->getName());
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
