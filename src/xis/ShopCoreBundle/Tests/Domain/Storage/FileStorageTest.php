<?php
namespace xis\ShopCoreBundle\Tests\Domain\Storage;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\ShopCoreBundle\Domain\Storage\FileStorage;

class FileStorageTest extends ProphecyTestCase
{
    /** @var FileStorage */
    private $fileStorage;
    /** @var string */
    private $filename;

    public function setup()
    {
        parent::setup();
        $this->filename = __DIR__ . '/file_storage_test' . time();
        $this->fileStorage = new FileStorage($this->filename);
    }

    public function teardown()
    {
        @unlink($this->filename);
        parent::teardown();
    }

    /**
     * @test
     */
    public function shouldStoreObjectInFile()
    {
        $obj = array('foo' => 'bar');

        $this->fileStorage->store($obj);

        $this->assertTrue(file_exists($this->filename));
    }

    /**
     * @test
     */
    public function shouldGetObjectFromFile()
    {
        $obj = array('foo' => 'bar');
        $this->fileStorage->store($obj);

        $outputObj = $this->fileStorage->get();

        $this->assertEquals($obj, $outputObj);
    }

    /**
     * @test
     */
    public function shouldRemoveFile()
    {
        $obj = array('foo' => 'bar');
        $this->fileStorage->store($obj);

        $this->fileStorage->clear();

        $this->assertFalse(file_exists($this->filename));
    }
} 