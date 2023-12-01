<?php

namespace MyProject\Models;

use DateTimeImmutable;
use MyProject\Exceptions\DbException;
use MyProject\Services\Db;

abstract class ActiveRecordEntity
{
    protected ?int $id = null;

    public function __set(string $name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return static[]
     * @throws DbException
     */
    public static function findAll(): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`;', [], static::class);
    }

    /**
     * @param int $id
     * @return static|null
     * @throws DbException
     */
    public static function getById(int $id): ?self
    {
        $db = Db::getInstance();
        $entity = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE id = :id;',
            [':id' => $id],
            static::class
        );
        return $entity ? $entity[0] : null;
    }

    public static function getTheLastEntries(int $numEntries): array
    {
        $db = Db::getInstance();
        return $db->query('SELECT * FROM `' . static::getTableName() . '`ORDER BY `id` DESC LIMIT ' . $numEntries . ';', [], static::class);
    }

    public static function findOneByColumn(string $columnName, $value): ?self
    {
        $db = Db::getInstance();
        $result = $db->query(
            'SELECT * FROM `' . static::getTableName() . '` WHERE `' . $columnName . '` = :value LIMIT 1;',
            [':value' => $value],
            static::class
        );
        if ($result === []) {
            return null;
        }
        return $result[0];
    }

    /**
     * @return void
     * @throws DbException
     */
    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();
        if ($this->id !== null) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    public function delete(): void
    {
        $sql = 'DELETE FROM ' . static::getTableName() . ' WHERE `id` = :id;';

        $db = Db::getInstance();
        $db->query($sql, [':id' => $this->id], static::class);

        $this->id = null;
    }

    public function getCreatedAt(): string
    {
        $date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->createdAt);
        return $date->format('d.m.Y') . ' в ' . $date->format('H:i');
    }

    abstract protected static function getTableName(): string;

    /**
     * @throws DbException
     */
    private function update(array $mappedProperties): void
    {
        $columns2params = [];
        $params2values = [];
        foreach ($mappedProperties as $column => $value) {
            $param = ':' . $column; // :column1
            $columns2params[] = '`' . $column . '` = ' . $param; // `column1` = :column1
            $params2values[$param] = $value; // [:column1 => value1]
        }
        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $columns2params) . ' WHERE id = :id';
        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);
    }

    /**
     * @throws DbException
     */
    private function insert(array $mappedProperties): void
    {
        $filteredProperties = array_filter($mappedProperties);

        $columns = [];
        $paramsNames = [];
        $params2values = [];
        foreach ($filteredProperties as $columnName => $value) {
            $columns[] = '`' . $columnName . '`';
            $paramName = ':' . $columnName;
            $paramsNames[] = $paramName;
            $params2values[$paramName] = $value;
        }

        $columnsViaSemicolon = implode(', ', $columns);
        $paramsNamesViaSemicolon = implode(', ', $paramsNames);

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ');';

        $db = Db::getInstance();
        $db->query($sql, $params2values, static::class);

        $this->id = $db->getLastInsertId();
        $this->refresh();
    }

    private function refresh(): void
    {
        $objectFromDb = static::getById($this->id);
        $reflector = new \ReflectionObject($objectFromDb);
        $properties = $reflector->getProperties();

        foreach ($properties as $property) {
            $propertyName = $property->getName();
            $this->$propertyName = $property->getValue($objectFromDb);
        }
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

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

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }


}