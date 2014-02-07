<?php
namespace xis\ShopCoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use xis\ShopCoreBundle\Domain\Repository\ProductRepository;

/**
 * @Route(service="xis.shop.controller.product")
 */
class ProductController
{
    /** @var HttpFacade */
    private $http;
    /** @var ProductRepository */
    private $productRepository;

    function __construct(HttpFacade $http, ProductRepository $productRepository)
    {
        $this->http = $http;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/products_all",name="products_all")
     * @Template()
     */
    public function allAction()
    {
        $page = $this->http->getRequestParam('page', 1);
        $pager = $this->productRepository->getProducts(60, $page);

        return array('pager' => $pager);
    }

}
