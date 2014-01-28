<?php

namespace xis\ShopCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class CategoryController extends Controller
{
    /**
     * @Template()
     */
    public function mainCategoriesAction()
    {
        /** @var CategoryRepository $catRepo */
        $catRepo = $this->getDoctrine()->getRepository('xisShopCoreBundle:Category');
        $categories = $catRepo->getMainCategories();

        return array('categories' => $categories);
    }
}
