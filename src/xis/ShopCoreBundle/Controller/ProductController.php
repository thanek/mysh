<?php
namespace xis\ShopCoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use xis\ShopCoreBundle\Repository\ProductRepository;

/**
 * @Route(service="xis.shop.controller.product")
 */
class ProductController
{
    /** @var  Request */
    private $request;
    /** @var  ProductRepository */
    private $productRepository;

    function __construct(Request $request, ProductRepository $productRepository)
    {
        $this->request = $request;
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/products_all",name="products_all")
     * @Template()
     */
    public function allAction()
    {
        $page = $this->request->get('page', 1);
        $pager = $this->productRepository->getProducts(60, $page);
        return array('pager' => $pager);
    }

}
