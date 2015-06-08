<?php

use mKomorowski\Config\Loader;

class FileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test passing to Loader not existing directory
     * @expectedException mKomorowski\Config\LoaderException
     */

    public function testInvalidDirectoryThrowException()
    {
        $loader = new Loader(realpath(__DIR__.'/files'));

        $loader->fetch();

        $this->setExpectedException('mKomorowski\Config\LoaderException');
    }

    /**
     * Test passing to Loader valid directory
     * Assert fetching setting to an array
     */

    public function testValidDirectoryReturnArray()
    {
        $loader = new Loader(realpath(__DIR__.'/config'));

        $data = $loader->fetch();

        $this->assertTrue(is_array($data));
    }

    /**
     * Assert that Loader will load every available setting file in given directory
     * @throws \mKomorowski\Config\LoaderException
     */

    public function testArraySettingsHasKey()
    {
        $loader = new Loader(realpath(__DIR__.'/config'));

        $data = $loader->fetch();

        $this->assertArrayHasKey('local', $data);
        $this->assertArrayHasKey('stage', $data);
        $this->assertArrayHasKey('production', $data);
    }

    /**
     * Assert that Loader will ignore directory while loading php settings files
     * @throws \mKomorowski\Config\LoaderException
     */

    public function testArraySettingsDoesNotHaveKey()
    {
        $loader = new Loader(realpath(__DIR__.'/config'));

        $data = $loader->fetch();

        $this->assertArrayNotHasKey('dir', $data);
    }

    /**
     * Assert passing empty directory
     * @throws \mKomorowski\Config\LoaderException
     */

    public function testValidDirectorryWithoutConfigFiles()
    {
        $loader = new Loader(realpath(__DIR__.'/empty'));

        $data = $loader->fetch();

        $this->assertEquals(0, count($data));
    }
}