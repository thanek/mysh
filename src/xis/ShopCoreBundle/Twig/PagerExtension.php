<?php
namespace xis\ShopCoreBundle\Twig;

use Symfony\Bundle\FrameworkBundle\Templating\Helper\RouterHelper;
use xis\ShopCoreBundle\Repository\Pager\Pager;

class PagerExtension extends \Twig_Extension
{
    /** @var RouterHelper */
    private $router;

    public function __construct(RouterHelper $router)
    {
        $this->router = $router;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            'pager' => new \Twig_Function_Method($this, 'pager', array('is_safe' => array('html'))),
        );
    }

    /**
     * @param Pager $pager
     * @return string
     */
    public function pager(Pager $pager)
    {

        $currentPage = $pager->getCurrentPage();
        $pageCount = $pager->getPageCount();

        $start = $this->getStartPage($currentPage);
        $end = $this->getEndPage($currentPage, $pageCount);

        $ret = '<ul class="pager">';
        $ret .= $this->beginPager($pager, $start);
        $ret .= $this->pagerBody($pager, $start, $end);
        $ret .= $this->endPager($pager, $end, $pageCount, $ret);
        $ret .= '</ul>';

        return $ret;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'pager';
    }

    /**
     * @param $i
     * @param Pager $pager
     * @return string
     */
    protected function pageButton($i, Pager $pager = null)
    {
        if (!$pager || $pager->getCurrentPage() == $i) {
            $btn = '<span>' . $i . '</span>';
        } else {
            $url = $this->router->generate('products_all', array('page' => $i));
            $btn = '<a href="' . $url . '">' . $i . '</a>';
        }
        return '<li>' . $btn . '</li>';
    }

    /**
     * @param Pager $pager
     * @param $start
     * @return string
     */
    protected function beginPager(Pager $pager, $start)
    {
        $ret = '';
        if ($start > 1) {
            $ret .= $this->pageButton(1, $pager);
            if ($start > 2) {
                $ret .= $this->pageButton('...');
            }
        }
        return $ret;
    }

    /**
     * @param $currentPage
     * @return int
     */
    protected function getStartPage($currentPage)
    {
        $start = 1;
        if ($currentPage > 5) {
            $start = $currentPage - 5;
            return $start;
        }
        return $start;
    }

    /**
     * @param $currentPage
     * @param $pageCount
     * @return mixed
     */
    protected function getEndPage($currentPage, $pageCount)
    {
        $end = $currentPage + 5;
        if ($end > $pageCount) {
            $end = $pageCount;
            return $end;
        }
        return $end;
    }

    /**
     * @param Pager $pager
     * @param $start
     * @param $end
     * @return string
     */
    protected function pagerBody(Pager $pager, $start, $end)
    {
        $ret = '';
        for ($i = $start; $i <= $end; $i++) {
            $ret .= $this->pageButton($i, $pager);
        }
        return $ret;
    }

    /**
     * @param Pager $pager
     * @param $end
     * @param $pageCount
     * @return string
     */
    protected function endPager(Pager $pager, $end, $pageCount)
    {
        $ret = '';
        if ($end < $pageCount) {
            if ($end < $pageCount + 2) {
                $ret .= $this->pageButton('...');
            }
            $ret .= $this->pageButton($pageCount, $pager);
        }
        return $ret;
    }
}