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

    protected $localEnvironment;

    protected $settings;

    protected $environments;

    public function __construct(ConfigLoader $loader, ConfigEnvironments $configEnvironments, $defaultEnvironment = 'production')
    {
        $this->settings = $loader->fetch();

        $this->environments = $configEnvironments->getSettings();

        $this->localEnvironment = $configEnvironments->getCurrentEnvironment($defaultEnvironment);

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

    /**
     * Check if key have value
     * @param string $key
     * @return bool
     */

    public function has($key)
    {
        return ($this->getValue($key) !== null) ? true : false;
    }

    /**
     * Get value from the settings
     * @param string $key
     * @return array|null
     */

    private function getValue($key)
    {
        $environments = array($this->getEnvironment());

        if(!in_array($this->defaultEnvironment, $environments)) array_push($environments, $this->defaultEnvironment);

        foreach($environments as $env)
        {
            if($this->extract($key, $env) !== null) return $this->extract($key, $env);
        }

        return null;
    }

    /**
     * Replace "key1.key2" notation with ["key1"]["key2"]
     * @param string $key
     * @param string $env
     * @return array|null
     */

    private function extract($key, $env)
    {
        $settings = $this->createSettings($env);

        $keys = explode('.', $key);

        foreach ($keys as $key)
        {
            $settings = (!empty($settings[$key])) ? $settings[$key] : null;
        }

        return $settings;
    }

    /**
     * Return array with environment settings, or empty array if environment does not exists
     * @param string $env
     * @return array
     */

    private function createSettings($env)
    {
        return (!empty($this->settings[$env])) ? $this->settings[$env] : null;
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