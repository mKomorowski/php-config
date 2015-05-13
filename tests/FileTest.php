<?php

use mKomorowski\Config\Loader;

class FileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException mKomorowski\Config\LoaderException
     */

    public function testInvalidDirectoryThrowException()
    {
        $loader = new Loader(realpath(__DIR__.'/files'));

        $loader->fetch();

        $this->setExpectedException('mKomorowski\Config\LoaderException');
    }

    public function testValidDirectoryReturnArray()
    {
        $loader = new Loader(realpath(__DIR__.'/config'));

        $data = $loader->fetch();

        $this->assertTrue(is_array($data));
    }

    public function testArraySettingsHasKey()
    {
        $loader = new Loader(realpath(__DIR__.'/config'));

        $data = $loader->fetch();

        $this->assertArrayHasKey('local', $data);
        $this->assertArrayHasKey('stage', $data);
        $this->assertArrayHasKey('production', $data);
    }

    public function testArraySettingsDoesNotHaveKey()
    {
        $loader = new Loader(realpath(__DIR__.'/config'));

        $data = $loader->fetch();

        $this->assertArrayNotHasKey('dir', $data);
    }

    public function testValidDirectorryWithoutConfigFiles()
    {
        $loader = new Loader(realpath(__DIR__.'/empty'));

        $data = $loader->fetch();

        $this->assertEquals(0, count($data));
    }
}