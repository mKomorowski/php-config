<?php namespace mKomorowski\Config;

use RecursiveIteratorIterator, RecursiveDirectoryIterator;

/**
 * Class Loader
 * @package mKomorowski\Config
 */

class Loader implements ConfigLoader
{
    /**
     * Directory with the settings files
     * @var string
     */
    protected $path;

    /**
     * @param string $path
     */

    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Load configuration settings
     * @return array
     * @throws LoaderException
     */

    public function fetch()
    {
        if(!$this->validateDirectory()) throw New LoaderException('Config path is not valid directory');

        return $this->buildConfigData();
    }

    /**
     * Build settings from scanned config files
     * @return array
     */

    private function buildConfigData()
    {
        $configBuild = array();

        $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->path, RecursiveDirectoryIterator::SKIP_DOTS));

        foreach($iterator as $name => $item)
        {
            if(strstr($name, '.php')){

                $envName = strtolower(substr($item->getFileName(), 0, strpos($item->getFileName(), '.')));

                $arraySettings = include $name;

                if(is_array($arraySettings)) $configBuild[$envName] = $arraySettings;
            }
        }

        return $configBuild;
    }

    /**
     * Check if the given path is a directory with correct read permissions
     * @return bool
     */

    private function validateDirectory()
    {
        if(is_dir($this->path) && is_readable($this->path)) return true;

        return false;
    }
}