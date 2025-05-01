<?php

namespace Larkbu\LonelySpace\Telegram\Command\Direction;

use Larkbu\LonelySpace\Exception\Ship\NotFoundShip;
use Larkbu\LonelySpace\Model\Ship\Ship;
use Larkbu\LonelySpace\Telegram\Message\Text;
use Larkbu\LonelySpace\Telegram\Message\TypeText;
use Larkbu\LonelySpace\Log\Log;
use Larkbu\LonelySpace\Log\TypeLog;
use Larkbu\LonelySpace\Telegram\Command\ICommand;
use SergiX44\Nutgram\Nutgram;

enum TypeDirection: string
{
    case Up = 'up';
    case Down = 'down';
    case Back = 'back';
    case Forward = 'forward';
    case Left = 'left';
    case Right = 'right';
}

abstract class Direction extends ICommand
{
    protected string $command;

    protected function runCommand(Nutgram $bot, Ship $ship, array $params = []): void
    {
        $ship->fly($this->command);
        $ship->save();

        $bot->sendMessage(
            Text::getText(
                TypeText::DIRECTION,
                ['axis' => $ship->getAxis(), 'axisHome' => $ship->getAxisHome()]
            ),
        );
    }
}
