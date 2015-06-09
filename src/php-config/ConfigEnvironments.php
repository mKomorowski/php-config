<?php namespace mKomorowski\Config;

/**
 * Interface ConfigEnvironments
 * @package mKomorowski\Config
 */

interface ConfigEnvironments
{
    /**
     * @return array
     */

    public function getSettings();

    /**
     * @param string $defaultEnvironment
     * @return string
     */

    public function getCurrentEnvironment($defaultEnvironment);
}