<?php

namespace Larkbu\LonelySpace\Model\Ship;

use Larkbu\LonelySpace\Model\ActiveRecordEntity;
use Larkbu\LonelySpace\Model\Universe\Coordinates;
use Larkbu\LonelySpace\Model\Universe\CoordinatesHome;

class Ship extends ActiveRecordEntity
{


    /** @var int $idPlayer id from telegram */

    protected int $idPlayer;

    /** @var string $coordinates string template 'xNUMBERyNUMBERzNUMBER' */
    protected string $coordinates;

    /** @var string $coordinatesHome string template 'xNUMBERyNUMBERzNUMBER' */
    protected string $coordinatesHome;

    /** @var string $firstName name from telegram */
    protected string $firstName;

    public function getIdPlayer(): int
    {
        return $this->idPlayer;
    }

    public function setIdPlayer(int $idPlayer): void
    {
        $this->idPlayer = $idPlayer;
    }

    public function getCoordinates(): string
    {
        return $this->coordinates;
    }

    public function getAxis(): array {
        return (new Coordinates($this->coordinates))->getAxis();
    }

    public function setCoordinates(string $coordinates): void
    {
        $objectCoordinates = new Coordinates($coordinates);
        $this->coordinates = $objectCoordinates->get();
    }

    public function getCoordinatesHome(): string
    {
        return $this->coordinatesHome;
    }

    public function getAxisHome(): array {
        return (new CoordinatesHome($this->coordinatesHome))->getAxis();
    }

    public function setCoordinatesHome(string $coordinatesHome): void
    {
        $objectCoordinates = new CoordinatesHome($coordinatesHome);
        $this->coordinatesHome = $objectCoordinates->get();
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }


    /**
     * @return string name table in DB
     */
    protected static function getTableName(): string
    {
        return 'ship';
    }

    /**
     * 
     * Function performs the flight of the ship in a given direction and in the number
     * 
     * @param string $direction direction: 'up', 'down', 'forward', 'back', 'left', 'right';
     * 
     * @param int $step flight step
     * 
     */
    public function fly(string $direction, int $step = 1): void
    {
        $coordinates = new Coordinates($this->coordinates);
        $coordinates->fly($direction, $step);
        $this->coordinates = $coordinates->get();
        $coordinatesHome = new CoordinatesHome($this->coordinatesHome);
        $coordinatesHome->fly($direction, $step);
        $this->coordinatesHome = $coordinatesHome->get();
    }
}
