<?php

use mKomorowski\Config\ConfigEnvironments;

class ConfigEnvironmentsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test passing settings in constructor
     */

    public function testConstruct()
    {
        $configEnvironments = new ConfigEnvironments(array(
           'local' => array('ubuntu', 'localhost', 'macbook')
        ));

        $environments = $configEnvironments->getSettings();

        $this->assertTrue(in_array('ubuntu', $environments['local']));

        $this->assertTrue(in_array('localhost', $environments['local']));

        $this->assertTrue(in_array('macbook', $environments['local']));

        $this->assertArrayHasKey('local', $environments);
    }

    /**
     * Assertion for creating new environment
     */

    public function testCreatingNewEnvironment()
    {
        $configEnvironments = new ConfigEnvironments;

        $configEnvironments->assignHosts('local', array('ubuntu'));

        $this->assertArrayHasKey('local', $configEnvironments->getSettings());
    }

    /**
     * Test given environment for having correct hosts
     */

    public function testNewlyCreatedEnvironmentHaveCorrectValues()
    {
        $configEnvironments = new ConfigEnvironments;

        $configEnvironments->assignHosts('local', array('ubuntu', 'localhost', 'macbook'));

        $configEnvironments->assignHosts('stage', array('staging'));

        $localEnvironment = $configEnvironments->getSettings()['local'];

        $this->assertTrue(count($localEnvironment) === 3);

        $this->assertTrue(in_array('localhost', $localEnvironment));

        $this->assertFalse(in_array('staging', $localEnvironment));
    }
}