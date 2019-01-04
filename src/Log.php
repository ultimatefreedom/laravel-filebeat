<?php

namespace Shallowman\Log;


class Log
{
    /**
     * Log an emergency message to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return void
     */
    public static function emergency($message, array $context = [])
    {
        self::writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an alert message to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return void
     */
    public static function alert($message, array $context = [])
    {
        self::writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a critical message to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return void
     */
    public static function critical($message, array $context = [])
    {
        self::writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an error message to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return void
     */
    public static function error($message, array $context = [])
    {
        self::writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a warning message to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return void
     */
    public static function warning($message, array $context = [])
    {
        self::writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a notice to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return void
     */
    public static function notice($message, array $context = [])
    {
        self::writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log an informational message to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return void
     */
    public static function info($message, array $context = [])
    {
        self::writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a debug message to the logs.
     *
     * @param  string $message
     * @param  array $context
     * @return void
     */
    public static function debug($message, array $context = [])
    {
        self::writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * Log a message to the logs.
     *
     * @param  string $level
     * @param  string $message
     * @param  array $context
     * @return void
     */
    public static function log($level, $message, array $context = [])
    {
        self::writeLog($level, $message, $context);
    }

    /**
     * Dynamically pass log calls into the writer.
     *
     * @param  string $level
     * @param  string $message
     * @param  array $context
     * @return void
     */
    public static function write($level, $message, array $context = [])
    {
        self::writeLog($level, $message, $context);
    }

    /**
     * Write a message to the log.
     *
     * @param  string $level
     * @param  string $message
     * @param  array $context
     * @return void
     */
    protected static function writeLog($level, $message, $context)
    {
        $request = request();
        $request->attributes->set('log_level', $level);
        $request->attributes->set('message', $message);
        $request->attributes->set('context', $context);
    }
}