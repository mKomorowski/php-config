<?php

use mKomorowski\Config\Loader;
use mKomorowski\Config\Environments;
use mKomorowski\Config\Config;

/**
 * Class ConfigTest
 */

class ConfigTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var object
     */

    protected $config;

    /**
     * @var array
     */

    protected $testEnvironments = array(
        'local' => array('ubuntu', 'localhost', 'macbook')
    );

    /**
     * Set Up Config object
     */

    public function setUp()
    {
        $configLoader = new Loader(__DIR__.'/config');

        $environments = new Environments($this->testEnvironments);

        $this->config = new Config($configLoader, $environments, 'production');
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
     * Assertion for has() function correctly determine if the key have value
     */

    public function testHas()
    {
        $this->assertTrue($this->config->has('debug'));

        $this->assertTrue($this->config->has('database'));

        $this->assertTrue($this->config->has('execution_time'));

        $this->assertTrue($this->config->has('database.host'));

        $this->assertFalse($this->config->has('database.error'));
    }
}