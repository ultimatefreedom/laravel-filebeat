<?php

namespace Shallowman\Log;

use Illuminate\Log\LogManager;
use Illuminate\Foundation\Application;

class LogService extends LogManager
{
    public function __construct(Application $app)
    {
        parent::__construct($app);
    }

    protected function configurationFor($name)
    {
        return $this->app['config']["app-log.channels.{$name}"];
    }
}