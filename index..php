<?php

    require __DIR__.'/vendor/autoload.php';

    $configLoader = new mKomorowski\Config\Loader(__DIR__.'/tests/empty');

    $config = new mKomorowski\Config\Config($configLoader, new mKomorowski\Config\Hosts);
