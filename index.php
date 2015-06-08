<?php

    require __DIR__.'/vendor/autoload.php';

    $configLoader = new mKomorowski\Config\Loader(__DIR__.'/tests/config');

    //$config = new mKomorowski\Config\Config($configLoader, new mKomorowski\Config\Hosts);