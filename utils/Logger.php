<?php

class Logger
{
    private static $logFile = ROOT . '/logs/error_logs.log';

    public static function logError($message)
    {
        $error = '[' . date('Y-m-d H:i:s') . '] ' . $message . "\n";
        file_put_contents(self::$logFile, $error, FILE_APPEND);
    }
}
