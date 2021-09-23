<?php

namespace app\core\database;
use app\core\Application;
use app\core\Model\Model;

/**
 * undocumented class
 */
abstract class DbModel extends Model
{
    abstract public static function tableName(): string;

    public function primaryKey(): string
    {
        return 'id';
    }

    public static function prepare($sql): \PDOStatement
    {
        return Application::$app->db->prepare($sql);
    }

    public function save()
    {
        $tb = $this->tableName;

        $attributes = $this->attributes();

        $params = array_map(fn($attr) => "('$attr')", $attributes);

        $statement = self::prepare("INSERT INTO 
            $tb (" . implode(",", $attributes) . ") 
            VALUES (" . implode(",", $params) . ")
        ");

        foreach ($attributes as $attribute)
        {
            $statement->bindValue(":$attribute", $this->{attribute});
        }

        $statement->execute();

        return true;
    }

    public static function findOne($where)
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $statement = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $statement->bindValue(":$key", $item);
        }
        $statement->execute();
        return $statement->fetchObject(static::class);
    }

}
