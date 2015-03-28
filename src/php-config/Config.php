<?php

namespace mKomorowski;

use Exception;

class Config {

    private $_configPath;

    private $_defaultEnvironment;

    private $_environments = array();
    private $_hosts = array();

    private $_settings = array();

    public function __construct($configPath){

        $this->_configPath = $configPath;

        $settingFiles = scandir($configPath);

        foreach($settingFiles as $file){

            if(strpos($file, '.php') === false) continue;

            $env = str_replace('.php', '', $file);

            $this->addEnvironment($env);
        }
    }

    /**
     * Register hostname to given settings
     * @param $env
     * @param $host
     * @return bool
     */

    public function addHostToEnvironment($env, $host){

        if($this->__checkIfEnvExists($env)){

            if(empty($this->_hosts[$env])) $this->_hosts[$env] = array();

            return array_push($this->_hosts[$env], $host);
        }

        return true;
    }

    /**
     * Check if requested key is registered under current hostname settings
     * By default default Environment will be returned (production)
     * @param $key
     * @return null
     */

    public function getSetting($key){

        $env = $this->__determineEnvironment();

        if(array_key_exists($key, $this->_settings[$env])){

            return $this->_settings[$env][$key];
        }elseif(array_key_exists($key, $this->_settings[$this->_defaultEnvironment])){

            return $this->_settings[$this->_defaultEnvironment][$key];
        }else{

            return null;
        }
    }

    /**
     * Register setting
     * @param $key
     * @param $value
     * @param bool $env
     * @return mixed
     */

    public function setSetting($key, $value, $env = false){

        if($env && $this->__checkIfEnvExists($env)){

            return $this->_settings[$env][$key] = $value;
        }

        return $this->_settings[$this->_defaultEnvironment][$key] = $value;
    }

    /**
     * Add new envionment and register settings
     * @param $env
     * @return bool
     */

    public function addEnvironment($env){

        if(!array_key_exists($env, $this->_environments)){

            array_push($this->_environments, $env);

            return $this->__registerSettings($env);
        }

        return false;
    }

    /**
     * Set default Environment
     * @param $env
     * @return mixed
     */

    public function setDefaultEnvironment($env){

        return $this->_defaultEnvironment = $env;
    }

    /**
     * If current hostname deosn't have registered settings, production will be returned by default
     * @return int|string
     */

    private function __determineEnvironment(){

        foreach($this->_hosts as $env => $hosts){

            if(in_array(gethostname(), $hosts)){

                return $env;
            }
        }

        return $this->_defaultEnvironment;
    }

    /**
     * Register settings from the file
     * @param $env
     * @return bool
     */

    private function __registerSettings($env){

        if($this->__checkIfEnvExists($env)){

            $settings = require_once($this->_configPath.'/'.$env.'.php');

            $this->_settings[$env] = $settings;

            return true;
        }

        return false;
    }

    /**
     * Check if setting file exists
     * @param $env
     * @return bool
     * @throws \Exception
     */

    private function __checkIfEnvExists($env){

        if(!file_exists($this->_configPath.'/'.$env.'.php')) throw New Exception('Environment '.$env.' doesn\'t exists');

        return true;
    }
}