<?php

namespace Shallowman\Log;

use Monolog\Formatter\JsonFormatter as BaseFormatter;

class JsonFormatter extends BaseFormatter
{
    public function format(array $content)
    {
        // The content which will write to application log file.
        // customize the log content by yourself
        unset($content['time']);
        unset($content['message']);

        if (empty($content['context'])) {
            return '';
        }

        return json_encode($content['context'], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL;
    }
}