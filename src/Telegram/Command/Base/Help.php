<?php

namespace Larkbu\LonelySpace\Telegram\Command\Base;

use Larkbu\LonelySpace\Model\Ship\Ship;
use Larkbu\LonelySpace\Telegram\Message\Text;
use Larkbu\LonelySpace\Telegram\Message\TypeText;
use SergiX44\Nutgram\Handlers\Type\Command;
use SergiX44\Nutgram\Nutgram;

class Help extends Command
{
    protected string $command='help';

    public function handle(Nutgram $bot): void
    {
        $user = $bot->user();
        if (empty(Ship::findOneByColumn('id_player', $user->id))) {
            $bot->sendMessage(Text::getText(TypeText::NOT_FOUND_SHIP));
        } else {
            $bot->sendMessage(Text::getText(TypeText::HELP));
        }
    }
}
