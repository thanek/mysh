<?php
namespace xis\ShopDoctrineAdapter\Repository\Search;

use Doctrine\ORM\QueryBuilder;
use xis\Shop\Repository\Search\SearchQueryBuilder;
use xis\Shop\Search\Parameter\FilterSet;

class DoctrineSearchQueryBuilder extends SearchQueryBuilder
{
    /** @var QueryBuilder */
    private $queryBuilder;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $this->queryBuilder = $queryBuilder;
    }

    protected function addCategoryFilter(FilterSet $query)
    {
        if ($query->getCategory()) {
            $category = $query->getCategory();
            $this->queryBuilder->join('p.category', 'c')
                ->andWhere('c.lft>=:lft')
                ->andWhere('c.rgt<=:rgt')
                ->setParameter('lft', $category->getLft())
                ->setParameter('rgt', $category->getRgt());
        }
    }

    protected function addPriceFromFilter(FilterSet $query)
    {
        if ($query->getPriceFrom()) {
            $priceFrom = $query->getPriceFrom();
            $this->queryBuilder->andWhere('p.price>=:priceFrom')
                ->setParameter('priceFrom', $priceFrom);
        }
    }

    protected function addPriceToFilter(FilterSet $query)
    {
        if ($query->getPriceTo()) {
            $priceTo = $query->getPriceTo();
            $this->queryBuilder->andWhere('p.price>=:priceTo')
                ->setParameter('priceTo', $priceTo);
        }
    }

    protected function addKeywordFilter(FilterSet $query)
    {
        if ($query->getKeyword()) {
            $keyword = $query->getKeyword();
            $this->queryBuilder->andWhere('p.name=:keyword')
                ->setParameter('keyword', $keyword);
        }
    }
}