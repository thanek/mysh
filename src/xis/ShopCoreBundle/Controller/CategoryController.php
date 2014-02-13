<?php
namespace xis\ShopCoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use xis\Shop\Repository\CategoryRepository;

class CategoryController
{
    /** @var CategoryRepository */
    private $categoryRepository;

    /**
     * @param CategoryRepository $categoryRepository
     */
    function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @Template()
     */
    public function mainCategoriesAction()
    {
        $categories = $this->categoryRepository->getMainCategories();

        return array('categories' => $categories);
    }
}
