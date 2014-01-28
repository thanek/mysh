<?php

namespace xis\ShopCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use xis\ShopCoreBundle\Entity\CategoryRepository;
use xis\ShopCoreBundle\Repository\ProductRepository;

class ProductController extends Controller
{
    /**
     * @Route("/products_all")
     * @Template()
     */
    public function allAction()
    {
        /** @var ProductRepository $repo */
        $repo = $this->getDoctrine()->getRepository('xisShopCoreBundle:Product');
        $products = $repo->getProducts(10, 0);

        return array('products' => $products);
    }

}
