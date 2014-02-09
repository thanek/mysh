<?php
namespace xis\ShopCoreBundle\Tests\Controller;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use xis\ShopCoreBundle\Controller\HttpFacade;

class HttpFacadeTest extends ProphecyTestCase
{
    /** @var  ContainerInterface|ObjectProphecy */
    private $container;
    /** @var HttpFacade */
    private $http;

    public function setup()
    {
        parent::setup();
        $this->container = $this->prophesize('Symfony\Component\DependencyInjection\ContainerInterface');
        $this->http = new HttpFacade($this->container->reveal());
    }

    /**
     * @test
     */
    public function shouldReturnRequestParam()
    {
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $request->get('someNumber', null)->willReturn(123);
        $this->container->get('request')->willReturn($request);

        $output = $this->http->getRequestParam('someNumber');

        $this->assertEquals(123, $output);
    }

    /**
     * @test
     */
    public function shouldAddFlashMessages()
    {
        $session = $this->prophesize('Symfony\Component\HttpFoundation\Session\Session');
        $this->container->get('session')->willReturn($session);

        $flashBag = $this->prophesize('Symfony\Component\HttpFoundation\Session\Flash\FlashBag');
        $session->getFlashBag()->willReturn($flashBag);
        $flashBag->add('notice', 'Hello World!')->shouldBeCalled();

        $this->http->addFlashMessage('notice', 'Hello World!');
    }

    /**
     * @test
     */
    public function shouldGenerateUrl()
    {
        $this->createRouterMock(
            'some_route_name', array('foo' => 'bar'), 'http://some.url/some/route?foo=bar');

        $output = $this->http->url('some_route_name', array('foo' => 'bar'));

        $this->assertEquals('http://some.url/some/route?foo=bar', $output);
    }

    /**
     * @test
     */
    public function shouldReturnRedirectResponseToGivenUrl()
    {
        $url = 'http://some.url';
        $output = $this->http->redirectToUrl($url);

        $this->assertEquals('Symfony\Component\HttpFoundation\RedirectResponse', get_class($output));
        $this->assertEquals($url, $output->getTargetUrl());
        $this->assertEquals(302, $output->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldReturnRedirectResponseToGivenRoute()
    {
        $this->createRouterMock(
            'some_route_name', array('foo' => 'bar'), 'http://some.url/some/route?foo=bar');

        $output = $this->http->redirect('some_route_name', array('foo' => 'bar'));

        $this->assertEquals('http://some.url/some/route?foo=bar', $output->getTargetUrl());
        $this->assertEquals(302, $output->getStatusCode());
    }

    /**
     * @test
     */
    public function shouldReturnRedirectResponseToReferer()
    {
        $url = 'http://some.url/blah';
        $request = new Request();
        $request->headers->add(array('referer' => $url));
        $this->container->get('request')->willReturn($request);

        $output = $this->http->redirectToReferer();

        $this->assertEquals('Symfony\Component\HttpFoundation\RedirectResponse', get_class($output));
        $this->assertEquals(302, $output->getStatusCode());
        $this->assertEquals($url, $output->getTargetUrl());
    }

    protected function createRouterMock($route, array $params, $outputUrl)
    {
        $router = $this->prophesize('Symfony\Bundle\FrameworkBundle\Routing\Router');
        $this->container->get('router')->willReturn($router);
        $router->generate($route, $params, UrlGeneratorInterface::ABSOLUTE_PATH)
            ->willReturn($outputUrl);
    }

}