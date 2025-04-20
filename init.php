<?php

use Larkbu\LonelySpace\Telegram\Command\Base\Help;
use Larkbu\LonelySpace\Telegram\Command\Base\Start;
use Larkbu\LonelySpace\Telegram\Command\Direction\Back;
use Larkbu\LonelySpace\Telegram\Command\Direction\Down;
use Larkbu\LonelySpace\Telegram\Command\Direction\Forward;
use Larkbu\LonelySpace\Telegram\Command\Direction\Left;
use Larkbu\LonelySpace\Telegram\Command\Direction\Right;
use Larkbu\LonelySpace\Telegram\Command\Direction\Up;
use SergiX44\Nutgram\Nutgram;
use SergiX44\Nutgram\RunningMode\Polling;

require __DIR__ . '/src/Config/creds.php';
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Service/Db.php';


try {

    $bot = new Nutgram(TOKEN_TELEGRAM); // new instance
    $bot->setRunningMode(Polling::class);

    $bot->registerCommand(Start::class);
    $bot->registerCommand(Help::class);


    $bot->registerCommand(Up::class);
    $bot->registerCommand(Down::class);
    $bot->registerCommand(Left::class);
    $bot->registerCommand(Right::class);
    $bot->registerCommand(Forward::class);
    $bot->registerCommand(Back::class);

    $bot->run();
} catch (\Larkbu\LonelySpace\Exception\DbException $th) {
    var_dump($th);
} catch (\Throwable $th) {
    var_dump($th);
}
