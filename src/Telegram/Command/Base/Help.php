<?php

namespace Larkbu\LonelySpace\Telegram\Command\Base;

use Larkbu\LonelySpace\Model\Ship\Ship;
use Larkbu\LonelySpace\Telegram\Command\ICommand;
use Larkbu\LonelySpace\Telegram\Message\Text;
use Larkbu\LonelySpace\Telegram\Message\TypeText;
use SergiX44\Nutgram\Nutgram;

class Help extends ICommand
{

    protected string $command = 'help';

    protected function runCommand(Nutgram $bot, Ship $ship, array $params = []):void{
        $bot->sendMessage(Text::getText(TypeText::HELP).' - new version');
    }
}
