<?php
namespace xis\ShopCoreBundle\Repository\Pager;

use Doctrine\ORM\QueryBuilder;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class PagerfantaDoctrinePager implements Pager
{
    /** @var Pagerfanta */
    private $pager;

    public function __construct(QueryBuilder $queryBuilder)
    {
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $this->pager = new Pagerfanta($adapter);
    }

    /**
     * @param int $limit
     * @return Pager
     */
    function setLimit($limit)
    {
        $this->pager->setMaxPerPage($limit);
        return $this;
    }

    /**
     * @param $page
     * @return Pager
     */
    function setCurrentPage($page)
    {
        $this->pager->setCurrentPage($page);
        return $this;
    }

    /**
     * @return int
     */
    function getCurrentPage()
    {
        return $this->pager->getCurrentPage();
    }

    /**
     * @return int
     */
    function getCount()
    {
        return $this->pager->getNbResults();
    }

    /**
     * @return int
     */
    function getPageCount()
    {
        return $this->pager->getNbPages();
    }

    /**
     * @return int
     */
    function getNextPage()
    {
        return $this->pager->getNextPage();
    }

    /**
     * @return int
     */
    function getPreviousPage()
    {
        return $this->pager->getPreviousPage();
    }

    /**
     * @return array|\Traversable
     */
    function getResults()
    {
        return $this->pager->getCurrentPageResults();
    }
}