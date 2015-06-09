<?php namespace mKomorowski\Config;

/**
 * Class Environments
 * @package mKomorowski\Config
 */

class Environments implements ConfigEnvironments
{
    /**
     * @var array
     */

    protected $settings;

    /**
     * Optional pass all settings in constructor
     * @param array $settings
     */

    public function __construct(array $settings = array())
    {
        $this->settings = $settings;
    }

    /**
     * Assing hosts to environment
     * @param string $environment
     * @param array $hosts
     */

    public function assignHosts($environment, array $hosts)
    {
        if(!isset($this->settings[$environment])) $this->createEnvironment($environment);

        foreach($hosts as $host)
        {
            array_push($this->settings[$environment], $host);
        }
    }

    /**
     * Return all settings
     * @return array mixed
     */

    public function getSettings()
    {
        return $this->settings;
    }

    /**
     * Return name of the currently used Environment
     * @param string $defaultEnvironment
     * @return string
     */

    public function getCurrentEnvironment($defaultEnvironment)
    {
        foreach($this->settings as $key => $value)
        {
            if(is_array($value) && in_array(gethostname(), $value)) return $key;
        }

        return $defaultEnvironment;
    }

    /**
     * Create environment
     * @param string $environment
     */

    private function createEnvironment($environment)
    {
        $this->settings[$environment] = array();
    }
}