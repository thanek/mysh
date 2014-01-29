<?php
namespace xis\ShopCoreBundle\Domain\Repository\Pager;

use Pagerfanta\Pagerfanta;

class PagerfantaPager implements Pager
{
    /** @var Pagerfanta */
    private $pager;

    public function __construct(Pagerfanta $pagerfanta)
    {
        $this->pager = $pagerfanta;
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