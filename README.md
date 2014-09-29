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
