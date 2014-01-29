<?php
namespace xis\ShopCoreBundle\Tests\Domain\Storage;

use Symfony\Bridge\Propel1\Tests\Propel1TestCase;
use xis\ShopCoreBundle\Domain\Storage\SessionStorage;

class SessionStorageTest extends Propel1TestCase
{
    /** @var SessionStorage */
    private $storage;

    public function setup()
    {
        parent::setup();
        $prefix = 'testStorage';
        $this->storage = new SessionStorage($prefix);
    }

    /**
     * @test
     */
    public function shouldUsePrefixInTheKey()
    {
        $id = '12345';

        $key = $this->storage->getKey($id);

        $this->assertEquals('testStorage::12345', $key);
    }

    /**
     * @test
     */
    public function shouldGenerateId()
    {
        $id = $this->storage->generateId();

        $this->assertNotNull($id);
    }

    /**
     * @test
     */
    public function shouldNotGenerateNewSessionId()
    {
        session_destroy();
        session_start();
        $currentSessionId = session_id();

        $storageSessionId = $this->storage->generateId();

        $this->assertEquals($currentSessionId, $storageSessionId);
    }

    /**
     * @test
     */
    public function shouldStoreObject()
    {
        $obj = array('foo' => 'bar');
        $key = $this->storage->getKey('baz');

        $this->storage->store('baz', $obj);
        $this->assertArrayHasKey($key, $_SESSION);
        $this->assertEquals($obj, $_SESSION[$key]);
    }

    /**
     * @test
     */
    public function shouldRemoveSessionEntry()
    {
        $obj = array('foo' => 'bar');
        $key = $this->storage->getKey('baz');
        $this->storage->store('baz', $obj);

        $this->storage->clear('baz');

        $this->assertArrayNotHasKey($key, $_SESSION);
    }
} 