<?php

namespace Larkbu\LonelySpace\Model;

use Larkbu\LonelySpace\Service\Db;

abstract class ActiveRecordEntity
{
    /** @var int */
    protected $id;

    /**
     *  @return int 
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function __set($name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    public static function create(array $params = []): ?ActiveRecordEntity
    {
        return Fabric::create(static::class, $params);
    }


    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    /**
     * function get record by id
     * @param int $id
     * @return static|null
     */

    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $entities = $db->query(
            'select * from ' . static::getTableName() . ' where id=:id',
            [':id' => $id],
            static::class,
        );

        return $entities ? $entities[0] : null;
    }

    /**
     * function get all records from table
     * 
     * @return static[]
     */

    public static function getAll(): array
    {
        $db = Db::getInstance();
        return $db->query('select * from ' . static::getTableName() . ';', [], static::class);
    }


    abstract protected static function getTableName(): string;

    private function mapPropertiesToDbFormat(): array
    {
        $reflector = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $propertyNameAsUnderscore = $this->camelCaseToUnderscore($propertyName);
            $mappedProperties[$propertyNameAsUnderscore] = $this->$propertyName;
        }

        return $mappedProperties;
    }


    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();

        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    public function update(array $mappedProperties): void
    {
        $columns2params = [];
        $params2values = [];

        $index = 1;

        foreach ($mappedProperties as $column => $value) {
            $param = ':param' . $index;
            $columns2params[] = $column . '=' . $param;
            $params2values[$param] = $value;
            $index++;
        }

        $psql = 'update ' . static::getTableName() . ' set ' . implode(', ', $columns2params) . ' where id=' . $this->id;

        $db = Db::getInstance();
        $db->query($psql, $params2values, static::class);
    }

    public function insert(array $mappedProperties): void
    {
        $filteredProperties = array_filter($mappedProperties);

        $params = [];
        $params2values = [];
        $columns = [];

        $index = 1;

        foreach ($filteredProperties as $column => $value) {
            $param = ':param' . $index;
            $params[] = $param;
            $columns[] = $column;
            $params2values[$param] = $value;
            $index++;
        }

        $psql = 'insert into ' . static::getTableName() . ' (' . implode(', ', $columns) . ') values (' . implode(', ', $params) . ')';

        $db = Db::getInstance();
        $db->query($psql, $params2values, static::class);
        $this->id = $db->getLastInsertId();
    }

    public function delete()
    {
        $db = Db::getInstance();
        $db->query(
            'delete from ' . static::getTableName() . ' where id=:id',
            [':id' => $this->id]
        );
        $this->id = null;
    }

    public static function findOneByColumn(string $columnName, $value): ?static
    {
        $db = Db::getInstance();
        $result = $db->query(
            'select * from ' . static::getTableName() . ' where ' . $columnName . '=:value LIMIT 1',
            [':value' => $value],
            static::class,
        );
        if ($result === [])
            return null;
        return $result[0];
    }
}
