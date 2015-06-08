<?php namespace mKomorowski\Config;

/**
 * Class Config
 * @package mKomorowski\Config
 */

class Config
{
    /**
     * @var string
     */
    
    protected $defaultEnvironment;

    protected $settings;

    protected $environments;

    public function __construct(Loader $loader, ConfigEnvironments $configEnvironments, $defaultEnvironment = 'production')
    {
        $this->settings = $loader->fetch();

        $this->environments = $configEnvironments->getSettings();

        $this->defaultEnvironment = $defaultEnvironment;
    }

    /**
     * Get Default Environment
     * @return string
     */

    public function getDefaultEnvironment()
    {
        return $this->defaultEnvironment;
    }

    /**
     * Return name of the currently used Environment
     * @return string
     */

    public function getEnvironment()
    {
        foreach($this->environments as $key => $value)
        {
            if(is_array($value) && in_array(gethostname(), $value)) return $key;
        }

        return $this->defaultEnvironment;
    }

    public function set($key, $value)
    {

    }

    public function has($key)
    {

    }

    public function get($key)
    {

    }

    /**
     * Set Default Environment
     * @param string $environment
     */

    public function setDefaultEnvironment($environment)
    {
        $this->defaultEnvironment = $environment;
    }
}