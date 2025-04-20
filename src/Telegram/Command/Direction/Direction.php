<?php

namespace Larkbu\LonelySpace\Telegram\Command\Direction;

use Larkbu\LonelySpace\Model\Ship\Ship;
use Larkbu\LonelySpace\Model\Universe\Coordinates;
use Larkbu\LonelySpace\Model\Universe\CoordinatesHome;
use SergiX44\Nutgram\Handlers\Type\Command;
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

abstract class Direction extends Command
{
    protected string $command;

    public function handle(Nutgram $bot): void
    {
        $user = $bot->user();
        if (empty(Ship::findOneByColumn('id_player', $user->id))) {
            $bot->sendMessage('go command "/start"');
        } else {
            $ship = Ship::findOneByColumn('id_player', $user->id);
            if ($ship !== null) {
                $ship->fly($this->command);
                $ship->save();
                $bot->sendMessage('coordinates - ' . $ship->getCoordinates() . "\ncoordinates home - " . $ship->getCoordinatesHome());
            } else {
                $bot->sendMessage('ship not found');
            }
        }
    }
}
