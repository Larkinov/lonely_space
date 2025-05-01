<?php

namespace Larkbu\LonelySpace\Log;

use Larkbu\LonelySpace\Config\Config;

enum TypeLog: string
{
    case DATA_BASE = "DATA_BASE";
    case COMMAND = "COMMAND";
    case PLAYER = "PLAYER";
    case ERROR = "ERROR";
}

class Log
{

    private const GENERAL_LOG = "logdata.log";

    public static function writeString(TypeLog $type, string|object $log)
    {
        if(gettype($log)==='object')
            $log = json_encode($log,JSON_UNESCAPED_UNICODE);
        $prepareLog = time() . ';' . date('Y-m-d H:i:s') . ';' . "$type->value;$log\n";

        file_put_contents(Config::STORAGE_LOG . self::GENERAL_LOG, $prepareLog, FILE_APPEND);
    }
}
