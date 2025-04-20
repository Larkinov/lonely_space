<?php

namespace Larkbu\LonelySpace\Model\Space;

use Larkbu\LonelySpace\Model\ActiveRecordEntity;
use Larkbu\LonelySpace\Model\Universe\Coordinates;

class SpaceObject extends ActiveRecordEntity
{

    /** @var string */
    protected string $coordinates;

    /** @var int */
    protected int $objectId;

    /** @var string */
    protected string $objectType;


    /**
     *  @return string
     */
    public function getCoordinates(): string
    {
        return $this->coordinates;
    }

    /**
     * @return void
     */
    public function setCoordinates(string $coordinates)
    {
        $objectCoordinates = new Coordinates($coordinates);
        $this->coordinates = $objectCoordinates->get();
    }

    /**
     *  @return int
     */
    public function getObjectId(): int
    {
        return $this->objectId;
    }

    /**
     * @return void
     */
    public function setObjectId(int $objectId)
    {
        $this->objectId = $objectId;
    }

    /**
     *  @return string
     */
    public function getObjectType(): string
    {
        return $this->objectType;
    }

    /**
     * @return void
     */
    public function setObjectType(string $objectType)
    {
        $this->objectType = $objectType;
    }

    protected static function getTableName(): string
    {
        return 'space_object';
    }
}
