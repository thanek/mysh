<?php
namespace xis\Shop\Tests\Search\Parameter;

use xis\Shop\Entity\Category;
use xis\Shop\Search\Parameter\FilterSet;
use xis\Shop\Tests\Entity\AbstractEntityTestCase;

class FilterSetTest extends AbstractEntityTestCase
{
    public function setup()
    {
        parent::setup();
        $this->entity = new FilterSet();
    }

    public function testSettersAndGetters()
    {
        $this->checkGetterAndSetter('keyword', 'foo');
        $this->checkGetterAndSetter('category', new Category());
        $this->checkGetterAndSetter('priceFrom', 123.23);
        $this->checkGetterAndSetter('priceTo', 234.44);
    }
} 