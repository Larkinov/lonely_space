<?php

namespace Larkbu\LonelySpace\Model\Space;

use Larkbu\LonelySpace\Model\ActiveRecordEntity;
use Larkbu\LonelySpace\Model\Space\ISpaceObject;

class Star extends ActiveRecordEntity implements ISpaceObject
{

    /** @var string $name star. DB type: varchar (100) not null.*/
    protected string $name;

    /** @var string $description. DB type: varchar(255).*/
    protected string $description;

    /**
     *  @return string  
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     *  @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return void
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     *  @return string
     */
    public function getType(): string
    {
        return 'star';
    }

    protected static function getTableName(): string
    {
        return 'star';
    }


}
