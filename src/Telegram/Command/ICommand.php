<?php

namespace Larkbu\LonelySpace\Telegram\Command;

use Larkbu\LonelySpace\Exception\Ship\NotFoundShip;
use Larkbu\LonelySpace\Model\Ship\Ship;
use Larkbu\LonelySpace\Telegram\Message\Text;
use Larkbu\LonelySpace\Telegram\Message\TypeText;
use Larkbu\LonelySpace\Log\Log;
use Larkbu\LonelySpace\Log\TypeLog;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;


abstract class ICommand extends Command
{

    public function handle(Nutgram $bot): void
    {
        Log::writeString(TypeLog::COMMAND, basename(static::class));

        $user = $bot->user();
        if (empty(Ship::findOneByColumn('id_player', $user->id))) {
            $bot->sendMessage(Text::getText(TypeText::NOT_FOUND_SHIP));
        } else {
            $ship = Ship::findOneByColumn('id_player', $user->id);
            Log::writeString(TypeLog::PLAYER, $user);
            if ($ship !== null) {
                $this->runCommand($bot, $ship);
            } else
                throw new NotFoundShip('ship not found in DB');
        }
    }

    abstract protected function runCommand(Nutgram $bot, Ship $ship, array $params = []):void;
}