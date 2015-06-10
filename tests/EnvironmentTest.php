<?php

use mKomorowski\Config\Environments;

class EnvironmentsTest extends \PHPUnit_Framework_TestCase
{
    protected $testEnvironments = array(
        'local' => array('ubuntu', 'localhost', 'macbook'),
        'stage' => array('staging')
    );

    /**
     * Test passing settings in constructor
     */

    public function testConstruct()
    {
        $configEnvironments = new Environments($this->testEnvironments);

        $environments = $configEnvironments->getSettings();;

        $this->assertTrue(in_array('ubuntu', $environments['local']));

        $this->assertTrue(in_array('localhost', $environments['local']));

        $this->assertTrue(in_array('macbook', $environments['local']));

        $this->assertTrue(in_array('staging', $environments['stage']));

        $this->assertArrayHasKey('local', $environments);
    }

    /**
     * Assertion for creating new environment
     */

    public function testCreatingNewEnvironment()
    {
        $configEnvironments = new Environments;

        $configEnvironments->assignHosts('local', array('ubuntu'));

        $this->assertArrayHasKey('local', $configEnvironments->getSettings());
    }

    /**
     * Test given environment for having correct hosts
     */

    public function testNewlyCreatedEnvironmentHaveCorrectValues()
    {
        $configEnvironments = new Environments;

        $configEnvironments->assignHosts('local', array('ubuntu', 'localhost', 'macbook'));

        $configEnvironments->assignHosts('stage', array('staging'));

        $localEnvironment = $configEnvironments->getSettings()['local'];

        $this->assertTrue(count($localEnvironment) === 3);

        $this->assertTrue(in_array('localhost', $localEnvironment));

        $this->assertFalse(in_array('staging', $localEnvironment));
    }

    /**
     * Assertion for getting current environment, which should by either 'production' or 'local' in case hostname in in $testEnvironment array
     */

    public function testGetEnvironment()
    {
        $configEnvironments = new Environments($this->testEnvironments);

        $expectedEnvironment = null;

        foreach($this->testEnvironments as $key => $value)
        {
            if(in_array(gethostname(), $value)) $expectedEnvironment = $key;
        }

        $this->assertEquals($expectedEnvironment, $configEnvironments->getCurrentEnvironment());
    }
}