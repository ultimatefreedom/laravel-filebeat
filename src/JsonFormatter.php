<?php

namespace Shallowman\Log;

use Monolog\Formatter\JsonFormatter as BaseFormatter;

class JsonFormatter extends BaseFormatter
{
    public function format(array $content)
    {
        // The content which will write to application log file.
        // Can customize the log content by yourself
        unset($content['time']);
        unset($content['message']);

        if (empty($record['context'])) {
            return '';
        }

        return $this->toJson($this->normalize($content['context']), true) . ($this->appendNewline ? PHP_EOL : '');
    }
}