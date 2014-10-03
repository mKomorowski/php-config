php-config
==========

Simple class supporting different configuration values based on the environment

Instalation
----------

Package can be installed via Composer by adding to ```composer.json``` require block.
```javascript
{
    "require": {
        "mkomorowski/php-config": "dev-master"
    }
}
```

Then update application packages by runing command.
```sh
php composer.phar update
```

Configuration
----------

Examples of files with application configuration options.

local.php
```php
return array(
  'database' => 'dev',
  'paypay_api_key' => 'test',
);
```

production.php
```php
return array(
  'database' => 'production',
  'paypal_api_key' => 'live',
);
```

In class constructor we are specifing path to directory with config files.
```php
$config = new mKomorowski/Config('/app/config');
```
It will register all settings under given environment names (it this example under ```local``` and ```production``` names).

It will pick first settings (```local```) as default one, you can change that by:
```php
$config = setDefaultEnvironment('production');
```

Then you can assign hostname to environment:
```php
$config->addHostToEnvironment('local', 'myComputer');
```
```php
$config->addHostToEnvironment('local', gethostname());
```

Usage
----------

To retrieve setting just use:
```php
$config->getSetting('database');
```
If your hosts is signed to specific environment it will return appropriate value. If not it look for default environment settings or return ```null``` if the key is not set

To add new setting you have to specify key, value and environment (If not, it will be registered under default one)
```php
$config->setSetting('timezone', 'UTC', 'local');
```
