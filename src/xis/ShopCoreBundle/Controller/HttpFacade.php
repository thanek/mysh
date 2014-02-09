<?php
namespace xis\ShopCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class HttpFacade
{
    /** @var ContainerInterface */
    private $container;

    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    public function getRequestParam($key, $default = null)
    {
        return $this->getRequest()->get($key, $default);
    }

    /**
     * @param string $type
     * @param string $message
     */
    public function addFlashMessage($type, $message)
    {
        $this->getSession()->getFlashBag()->add($type, $message);
    }

    /**
     * @param $route
     * @param array $parameters
     * @param int $status
     * @return RedirectResponse
     */
    public function redirect($route, $parameters = array(), $status = 302)
    {
        $url = $this->url($route, $parameters);
        return $this->redirectToUrl($url, $status);
    }

    /**
     * @param int $status
     * @return RedirectResponse
     */
    public function redirectToReferer($status = 302)
    {
        $url = $this->getReferer();
        return new RedirectResponse($url, $status);
    }

    /**
     * @return string
     */
    public function getReferer()
    {
        return $this->getRequest()->headers->get('referer');
    }

    /**
     * @param $url
     * @param int $status
     * @return RedirectResponse
     */
    public function redirectToUrl($url, $status = 302)
    {
        return new RedirectResponse($url, $status);
    }

    /**
     * @param string $route
     * @param array $parameters
     * @param bool $referenceType
     * @return string
     */
    public function url($route, $parameters = array(), $referenceType = UrlGeneratorInterface::ABSOLUTE_PATH)
    {
        return $this->getRouter()->generate($route, $parameters, $referenceType);
    }

    /**
     * @return Request
     */
    protected function getRequest()
    {
        return $this->container->get('request');
    }

    /**
     * @return Session
     */
    protected function getSession()
    {
        return $this->container->get('session');
    }

    /**
     * @return Router
     */
    protected function getRouter()
    {
        return $this->container->get('router');
    }
}