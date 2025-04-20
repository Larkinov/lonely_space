<?php

namespace Larkbu\LonelySpace\Telegram\Command\Direction;

use Larkbu\LonelySpace\Exception\Ship\NotFoundShip;
use Larkbu\LonelySpace\Model\Ship\Ship;
use Larkbu\LonelySpace\Telegram\Message\Text;
use Larkbu\LonelySpace\Telegram\Message\TypeText;
use Larkbu\LonelySpace\Log\Log;
use Larkbu\LonelySpace\Log\TypeLog;
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
        Log::writeString(TypeLog::COMMAND, "init $this->command");

        $user = $bot->user();
        if (empty(Ship::findOneByColumn('id_player', $user->id))) {
            $bot->sendMessage(Text::getText(TypeText::NOT_FOUND_SHIP));
        } else {
            $ship = Ship::findOneByColumn('id_player', $user->id);
            if ($ship !== null) {
                $ship->fly($this->command);
                $ship->save();

                $bot->sendMessage(
                    Text::getText(
                        TypeText::DIRECTION,
                        ['coordinates' => $ship->getCoordinates(), 'coordinatesUser' => $ship->getCoordinatesHome()]
                    ),
                );
            } else
                throw new NotFoundShip('ship not found in DB');
        }
    }
}
