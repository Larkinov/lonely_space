<?php

namespace Larkbu\LonelySpace\Telegram\Message;

use Larkbu\LonelySpace\Exception\Message\UnknownTypeText;
use Larkbu\LonelySpace\Log\Log;
use Larkbu\LonelySpace\Log\TypeLog;

enum TypeText: string
{
    case START = 'START';
    case START_HAS = 'START_HAS';
    case NOT_FOUND_SHIP = 'NOT_FOUND_SHIP';
    case DIRECTION = 'DIRECTION';
    case HELP = 'HELP';
}

class Text
{


    public static function getText(TypeText $type, array $params = []): string
    {
        switch ($type) {
            case TypeText::START:
                return "Мы создали вам космический корабль!";
            case TypeText::START_HAS:
                return "У вас уже есть космический корабль под номером - ".$params['id'];
            case TypeText::NOT_FOUND_SHIP:
                return "У вас еще пока нет космического корабля. Вы можете создать его через команду '/start'";
            case TypeText::DIRECTION:
                return "Корабль прибыл в место назначения. Наши новые координаты:\nx: " . $params['axisHome']['x'] . "\ny: " . $params['axisHome']['y'] . "\nz: " . $params['axisHome']['z'] . "\nКоординаты по Вселенной:\nx: " . $params['axis']['x'] . "\ny: " . $params['axis']['y'] . "\nz: " . $params['axis']['z'];
            case TypeText::HELP:
                return "Описание помощи";
            default:
                throw new UnknownTypeText('unknown type text');
        }
    }
}
