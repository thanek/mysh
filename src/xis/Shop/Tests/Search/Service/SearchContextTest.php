<?php
namespace xis\Shop\Tests\Search\Service;

use xis\Shop\Search\Parameter\FilterSetBuilder;
use xis\Shop\Search\Service\SearchContext;
use xis\Shop\Tests\Entity\AbstractEntityTestCase;
use xis\ShopDoctrineAdapter\Repository\DoctrineCategoryRepository;

class SearchContextTest extends AbstractEntityTestCase
{
    public function setup()
    {
        parent::setup();
        $this->entity = new SearchContext();
    }

    public function testGettersAndSetters()
    {
        $this->checkGetterAndSetter('categoryRepository', null);
        $this->checkGetterAndSetter('productRepository', null);
        $this->checkGetterAndSetter('filterSetBuilder', new FilterSetBuilder());
    }
} 