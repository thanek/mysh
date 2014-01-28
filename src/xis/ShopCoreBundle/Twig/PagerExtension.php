<?php
namespace xis\ShopCoreBundle\Twig;

use Symfony\Bundle\FrameworkBundle\Templating\Helper\RouterHelper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use xis\ShopCoreBundle\Repository\Pager\Pager;

class PagerExtension extends \Twig_Extension
{
    /** @var ContainerInterface */
    private $container;
    /** @var RouterHelper */
    private $router;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->router = $this->container->get('templating.helper.router');
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
        $ret = '<ul class="pager">';

        $start = 1;
        if ($pager->getCurrentPage() > 5) {
            $start = $pager->getCurrentPage() - 5;
        }
        $end = $pager->getCurrentPage() + 5;
        if ($end > $pager->getPageCount()) {
            $end = $pager->getPageCount();
        }


        if ($start > 1) {
            $ret .= $this->pageButton(1, $pager);
            if ($start > 2) {
                $ret .= $this->pageButton('...');
            }
        }

        for ($i = $start; $i <= $end; $i++) {
            $ret .= $this->pageButton($i, $pager);
        }

        if ($end < $pager->getPageCount()) {
            if ($end < $pager->getPageCount() + 2) {
                $ret .= $this->pageButton('...');
            }
            $ret .= $this->pageButton($pager->getPageCount(), $pager);
        }

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
}