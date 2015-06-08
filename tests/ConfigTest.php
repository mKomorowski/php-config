<?php

use mKomorowski\Config\Loader;
use mKomorowski\Config\ConfigEnvironments;
use mKomorowski\Config\Config;

/**
 * Class ConfigTest
 */

class ConfigTest extends PHPUnit_Framework_TestCase
{
    protected $config;

    protected $testEnvironments = array(
        'local' => array('ubuntu', 'localhost', 'macbook')
    );

    /**
     * Set Up Config object
     */

    public function setUp()
    {
        $configLoader = new mKomorowski\Config\Loader(__DIR__.'/config');

        $environments = new mKomorowski\Config\ConfigEnvironments($this->testEnvironments);

        $this->config = new mKomorowski\Config\Config($configLoader, $environments, 'production');
    }

    /**
     * Assertion for default environment
     */

    public function testDefaultEnvironment()
    {
        $this->assertEquals('production', $this->config->getDefaultEnvironment());
    }

    /**
     * Assertion for setting new default environment
     */

    public function testSettingNewEnviroment()
    {
        $this->config->setDefaultEnvironment('stage');

        $this->assertEquals('stage', $this->config->getDefaultEnvironment());

        $this->assertFalse($this->config->getDefaultEnvironment() == 'production');
    }

    /**
     * Assertion for getting current environment, which should by either 'production' or 'local' in case hostname in in $testEnvironment array
     */

    public function testGetEnvironment()
    {
        $expectedEnvironment = (in_array(gethostname(), $this->testEnvironments['local'])) ? 'local' : 'production';

        $this->assertEquals($expectedEnvironment, $this->config->getEnvironment());
    }
}