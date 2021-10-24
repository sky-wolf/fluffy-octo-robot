<?php

namespace Framework\Database\Migration;

use app\Database\Connection\MysqlConnection;
use app\Database\Exception\MigrationException;
use app\Database\Migration\Field\Field;
use app\Database\Migration\Field\BoolField;
use app\Database\Migration\Field\DateTimeField;
use app\Database\Migration\Field\FloatField;
use app\Database\Migration\Field\IdField;
use app\Database\Migration\Field\IntField;
use app\Database\Migration\Field\StringField;
use app\Database\Migration\Field\TextField;

class MysqlMigration extends Migration
{
protected MysqlConnection $connection;
protected string $tabel;
protected string  $type;
protected array  $drops = [];


    public function __construct(MysqlConnection $connectionl, string $table, string $type)
    {
        $this->connection = $connection;
        $this->table = $table;
        $this->type = $type;
    }

    public function execute()
    {
        $fields = array_map(fn($field)=> StringForField($field), $fields);

        $primary = array_filter($this->fields, fn($field) => $field instanceof IdField);
        $primaryKey = isset($primary[0]) ? "PRIMARY KEY (`{$primary[0]}`)" : '';

        if($this->type === 'create')
        {
            $fields = join(PHP_EOL, array_map(fn($field)=> "{$field}, ", $fields));

            $query = "
                CREAT TABEL `{$this->table}`(
                    {$fields}
                    {$primaryKey}
                )ENGINE=innoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;);
            ";
        }

        if($this->type === 'alter')
        {
            $fields = join(PHP_EOL, array_map(fn($field)=> "{$field}, ", $fields));
            $drops = join(PHP_EOL, array_map(fn($drop)=> "DROP COLUM `{$drop}`;", $this->drops));

            $query = "
                ALTER TABLE `{$this->table}`
                    {$fields}
                    {$drops}
            ";
        }

        $statement = $this->connection->pdo->prepare($query);
        $statement->execute();
    }

    public function StringForField(Field $field): static
    {
        $perfix = '';

        if($this->type === 'alter')
        {
            $perfix = 'ADD';
        }

        if($this->alter)
        {
            $perfix = 'MODIFY';
        }

        if($field instanceof BoolField)
        {
            $template = "{$prefix} `{$field->name}` tinyint(4)";

            if($field->nullable)
            {
                $template .= " DEFAULT NULL";
            }

            if($field->default !== null)
            {
                $default = (int) $field->default;
                $template .= " DEFAULT {$default}";
            }
            return $template;
        }

        if($field instanceof DateTimeField)
        {
            $template = "{$prefix} `{$field->name}` datetime";

            if($field->nullable)
            {
                $template .= " DEFAULT NULL";
            }

            if($field->default === 'CURRENT_TIMESTAMP')
            {
                $template .= " DEFAULT CURRENT_TIMESTAMP";
            }elseif ($field->default !== null)
            {
                $template .= " DEFAULT {$field->default}";
            }
            return $template;
        }

        if($field instanceof FloatField)
        {
            $template = "{$prefix} `{$field->name}` float";

            if($field->nullable)
            {
                $template .= " DEFAULT NULL";
            }

            if ($field->default !== null)
            {
                $template .= " DEFAULT {$field->default}";
            }
            return $template;
        }

        if($field instanceof IdField)
        {
            $template = "{$prefix} `{$field->name}` int(11) unsigned NOT NULL AUTO_INCREMENT";

            if($field->nullable)
            {
                $template .= " DEFAULT NULL";
            }

            if ($field->default !== null)
            {
                $template .= " DEFAULT {$field->default}";
            }
            return $template;
        }

        if($field instanceof TextField)
        {
            return "{$prefix} `{$field->name}` text";
        }

        throw new MigrationException("Unrecognised field type for {$field->name}");
    }

    public function dropColumn(string $name): static
    {
        $this->drops[] = $name;
        return $this;
    }
}