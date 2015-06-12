php-config
==========

A simple class supporting different configuration values based on the environment

Installation
----------

The package can be installed via Composer by adding to the ```composer.json``` require block.
```javascript
{
    "require": {
        "mkomorowski/php-config": "dev-master"
    }
}
```

Then update application packages by running the command:
```sh
php composer.phar update
```

Configuration
----------

Examples of files with application configuration options.

local.php
```php
return array(
        'debug' => true,
        'database' => array(
            'host' => '127.0.0.1',
            'password' => 'password',
        ),
);
```

production.php
```php
return array(
        'debug' => false,
        'database' => array(
            'host' => 'rds.amazon.com',
            'password' => 'password',
        ),
);
```

In the settings loader we are specifying the path to the directory with config files.
```php
$loader = new mKomorowski\Config\Loader('/app/config');
```
Next we are defining the environment settings:
```php
$environment = new mKomorowski\Config\Environments(array(
    'local' => array('local', 'MacBook.local'),
    'stage' => array('cent_os_stage')
));
```
Finally we initialize the Config class, passing settings and environments. The third paramater is an optional default environment.
```php
$config = new mKomorowski\Config\Config($loader, $environment, 'stage');
```

We can change the default environment later by:
```php
$config->setDefaultEnvironment('production');
```
Usage
----------

To retrieve the settings just use:
```php
$config->get('debug');
```
Accessing nested values is possible with dotted notation
```php
$config->get('database.hostname');
```
If your hosts is signed to a specific environment it will return the appropriate value. If not it will look for default environment settings or return ```null``` if the key is not set.


