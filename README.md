php-config
==========

Simple class supporting different configuration values based on the environment

Instalation
----------

Package can be installed via Composer by adding to ```composer.json``` require block.
```javascript
{
    "require": {
        "aws/aws-sdk-php-laravel": "1.*"
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

production.php
```php
return array(
  'database' => 'production',
  'paypal_api_key' => 'live',
);
```
local.php
```php
return array(
  'database' => 'dev',
  'paypay_api_key' => 'test',
);
```

In class constructor we are specifing path to directory with config files
```php
$config = new mKomorowski/Config('/app/config');
```

By default it will look for ```production.php``` file, but you can change default environment name by
```php
$config->setDefaultEnvironment('global');
```
You can add custom environment by:
```php
$config->addEnvironment('local');
```
And then assign hostname to environment:
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
