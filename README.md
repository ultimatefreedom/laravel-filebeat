# laravel-filebeat
## Installation
   
   Require the `shallowman/laravel-filebeat` package in your `composer.json` and update your dependencies:
   ```sh
   $ composer require shallowman/laravel-filebeat
   ```
   
   For laravel >=5.5 that's all. This package supports Laravel new [Package Discovery](https://laravel.com/docs/5.5/packages#package-discovery).
## Configuration

The defaults are set in `config/app-log.php`. Copy this file to your own config directory to modify the values. You can publish the config using this command:
```sh
$ php artisan vendor:publish --provider="Shallowman\Log\ServiceProvider"
```

> **Note:** If you want to rewrite the log path please provide a real path.

```php
return [
    'channels' => [
        'filebeat' => [
            'driver' => 'daily',
            'path' => storage_path('logs/app.log'),
            'tap' => [Shallowman\Log\LogFormatter::class],
            'days' => 7,
        ],
    ],
];
```