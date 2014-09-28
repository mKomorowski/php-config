<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 28/09/14
 * Time: 12:50
 */

namespace mKomorowski;

use Exception;

class Config {

    private $__configPath;

    private $__defaultEnvironment = 'production';

    private $__environments = array(
        'production', 'local'
    );

    private $__hosts = array();

    private $__settings = array();

    public function __construct($configPath){

        $this->__configPath = $configPath;

        foreach($this->__environments as $env){

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

            $this->__hosts[$env] = array();

            return array_push($this->__hosts[$env], $host);
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

        if(array_key_exists($key, $this->__settings[$env])){

            return $this->__settings[$env][$key];
        }elseif(array_key_exists($key, $this->__settings[$this->__defaultEnvironment])){

            return $this->__settings[$this->__defaultEnvironment][$key];
        }else{

            return null;
        }
    }

    /**
     * Add new envionment and register settings
     * @param $env
     * @return bool
     */

    public function addEnvironment($env){

        if(!array_key_exists($env, $this->__environments)){

            array_push($this->__environments, $env);

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

        return $this->__defaultEnvironment = $env;
    }

    /**
     * If current hostname deosn't have registered settings, production will be returned by default
     * @return int|string
     */

    private function __determineEnvironment(){

        foreach($this->__hosts as $env => $hosts){

            if(in_array(gethostname(), $hosts)){

                return $env;
            }
        }

        return $this->__defaultEnvironment;
    }

    /**
     * Register settings from the file
     * @param $env
     * @return bool
     */

    private function __registerSettings($env){

        if($this->__checkIfEnvExists($env)){

            $settings = require_once($this->__configPath.'/'.$env.'.php');

            $this->__settings[$env] = $settings;

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

        if(!file_exists($this->__configPath.'/'.$env.'.php')) throw New Exception('Config file '.$env.'.php not found in directoy '.$this->__configPath);

        return true;
    }
} 