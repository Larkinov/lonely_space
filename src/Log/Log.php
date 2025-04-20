<?php

namespace Larkbu\LonelySpace\Log;

use Larkbu\LonelySpace\Config\Config;

enum TypeLog: string
{
    case DATA_BASE = "DATA_BASE";
    case COMMAND = "COMMAND";
}

class Log
{

    private const GENERAL_LOG = "logdata.log";

    public static function writeString(TypeLog $type, string $log)
    {
        $prepareLog = time() . ';' . date('Y-m-d H:i:s') . ';' . "$type->value;$log\n";

        file_put_contents(Config::STORAGE_LOG . self::GENERAL_LOG, $prepareLog, FILE_APPEND);
    }
}
