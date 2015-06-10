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
     * @return null|string
     */

    public function getCurrentEnvironment();
}