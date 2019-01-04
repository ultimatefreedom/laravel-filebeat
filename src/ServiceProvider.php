<?php

namespace Shallowman\Log;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->configPath(), 'app-log');
        $this->app->singleton(LogService::class, function () {
            return new LogService($this->app);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $path = $this->configPath();
        $this->publishes([$path => config_path('app-log.php')], 'config');
        $this->mergeConfigFrom($path, 'app-log');
    }

    protected function configPath()
    {
        return realpath(__DIR__ . '/../config/app-log.php');
    }
}