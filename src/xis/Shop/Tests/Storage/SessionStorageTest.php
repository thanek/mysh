<?php
namespace xis\Shop\Tests\Storage;

use Prophecy\PhpUnit\ProphecyTestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use xis\Shop\Storage\SessionStorage;

class SessionStorageTest extends ProphecyTestCase
{
    /** @var SessionStorage */
    private $storage;
    /** @var SessionInterface */
    private $session;

    public function setup()
    {
        parent::setup();

        $key = 'testStorage';
        $this->session = $this->prophesize('Symfony\Component\HttpFoundation\Session\SessionInterface');
        $this->storage = new SessionStorage($key, $this->session->reveal());
    }

    /**
     * @test
     */
    public function shouldStoreObject()
    {
        $obj = array('foo' => 'bar');

        $this->session->set('testStorage', $obj)->shouldBeCalled();

        $this->storage->store($obj);
    }

    /**
     * @test
     */
    public function shouldGetStoredObject()
    {
        $obj = array('foo' => 'bar');
        $this->storage->store($obj);
        $this->session->get('testStorage')->willReturn($obj);

        $objGot = $this->storage->get();

        $this->assertEquals($objGot, $obj);
    }

    /**
     * @test
     */
    public function shouldRemoveSessionEntry()
    {
        $obj = array('foo' => 'bar');
        $this->storage->store($obj);

        $this->session->remove('testStorage')->shouldBeCalled();

        $this->storage->clear();
    }
} 