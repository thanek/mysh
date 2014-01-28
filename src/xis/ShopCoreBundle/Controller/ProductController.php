<?php

namespace xis\ShopCoreBundle\Controller;

use Knp\Component\Pager\Paginator;
use Pagerfanta\View\DefaultView;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use xis\ShopCoreBundle\Entity\CategoryRepository;
use xis\ShopCoreBundle\Repository\ProductRepository;

/**
 * @Route(service="xis.shop.controller.product")
 */
class ProductController extends Controller
{
    /** @var  Request */
    private $request;
    /** @var  ProductRepository */
    private $productRepository;

    function __construct(RequestStack $requestStack, ProductRepository $productRepository)
    {
        $this->request = $requestStack->getCurrentRequest();
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/products_all",name="products_all")
     * @Template()
     */
    public function allAction()
    {
        $page = $this->request->get('page',1);
        $pager = $this->productRepository->getProducts(60, $page);
        return array('pager' => $pager);
    }

}
