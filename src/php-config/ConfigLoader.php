<?php namespace mKomorowski\Config;

/**
 * Interface ConfigLoader
 * @package mKomorowski\Config
 */

interface ConfigLoader
{
    /**
     * @return array
     */

    public function fetch();
}