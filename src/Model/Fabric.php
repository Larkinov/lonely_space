<?php

namespace Larkbu\LonelySpace\Model;

use Larkbu\LonelySpace\Model\Ship\Ship;
use Larkbu\LonelySpace\Model\Space\SpaceObject;
use Larkbu\LonelySpace\Model\Space\Star;
use Larkbu\LonelySpace\Model\Universe\Coordinates;
use Larkbu\LonelySpace\Model\Universe\CoordinatesHome;

class Fabric
{
    public static function create(string $classname, array $params = []): ?ActiveRecordEntity
    {
        switch ($classname) {
            case Star::class:
                $star = new Star();
                $star->setName($params['name']);
                $star->setDescription($params['description']);
                return $star;
            case SpaceObject::class:
                $space = new SpaceObject();
                $space->setObjectType($params['type']);
                $space->setObjectId($params['objectId']);
                $space->setCoordinates($params['coordinates']);
                return $space;

            case Ship::class:
                $ship = new Ship();
                $ship->setIdPlayer($params['idPlayer']);
                $ship->setFirstName($params['firstName']);
                $ship->setCoordinates($params['coordinates']);
                $ship->setCoordinatesHome($params['coordinatesHome']);
                return $ship;
            default:
                return null;
        }
    }
}
