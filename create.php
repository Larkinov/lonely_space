<?php

use Larkbu\LonelySpace\Model\Universe\Universe;

require __DIR__ . '/src/Model/Universe.php';
require __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Service/Db.php';


try {

    Universe::createSpaceObjects();
    
} catch (\Larkbu\LonelySpace\Exception\DbException $th) {
    var_dump($th);
} catch (\Throwable $th) {
    var_dump($th);
}
