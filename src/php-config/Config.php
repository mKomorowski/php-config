<?php

namespace mKomorowski\Config;

class Config{

    protected $hosts;
    protected $settings = array();
    protected $environments = array();
    protected $defaultEnvironment;

    public function __construct(Loader $loader, Hosts $hosts, $defaultEnvironment = 'production')
    {
        $this->hosts = $hosts;

        $this->settings = $loader->fetch();

        $this->defaultEnvironment = $defaultEnvironment;

        $this->environments = array_keys($this->settings);
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
}