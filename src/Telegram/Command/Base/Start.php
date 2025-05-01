<?php

namespace Larkbu\LonelySpace\Telegram\Command\Base;

use Larkbu\LonelySpace\Model\Ship\Ship;
use Larkbu\LonelySpace\Telegram\Message\Text;
use Larkbu\LonelySpace\Telegram\Message\TypeText;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class Start extends Command
{
    protected string $command = 'start';

    public function handle(Nutgram $bot): void
    {
        $user = $bot->user();
        if (empty(Ship::findOneByColumn('id_player', $user->id))) {
            $ship = Ship::create(
                [
                    'idPlayer' => $user->id,
                    'firstName' => $user->first_name,
                    'coordinates' => 'x1y4z5',
                    'coordinatesHome' => 'x0y0z0'
                ]
            );
            $ship->save();
            $bot->sendMessage(Text::getText(TypeText::START));
        } else {
            $newShip = Ship::findOneByColumn('id_player', $user->id);
            $bot->sendMessage(Text::getText(TypeText::START_HAS, ['id' => $newShip->getIdPlayer()]));
        }
    }
}
