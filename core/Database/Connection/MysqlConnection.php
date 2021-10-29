<?php

namespace Framework\Database\Connection;

use Framework\Application;
use Framework\Support\DotEnv;
use Framework\Database\Database;

use Framework\Database\QueryBuilder\MysqlQueryBuilder;
use Framework\Database\Migration\MysqlMigration;
use InvalidArgumentException;
use Pdo;


class MysqlConnection extends Connection
{
    public PDO $pdo;
    private string $database;

    public function __construct()
    {
        if( empty(getenv('DATABASE_HOST')) || empty(getenv('DATABASE_DB')) || empty(getenv('DATABASE_USER')))
        {
            throw new InvalidArgumentException('Connection incorrectly configured');
        }
       
        $dbDns = 'mysql:host=' . getenv('DATABASE_HOST') . ';dbname=' . getenv('DATABASE_DB') . ';';

        $user = getenv('DATABASE_USER');
        $pass = getenv('DATABASE_PASSWORD');

        $this->database = getenv('DATABASE_DB');

        try 
        {
            $this->pdo = new PDO($dbDns, $user, $pass);
        } 
        catch (PDOException $e) 
        {
            echo $e->getMessage();
        }
    }

    
    public function pdo(): Pdo
    {
        return $this->pdo;
    }

    
    public function query()
    {
        return new MysqlQueryBuilder($this);
    }


    public function createTable(string $tabel)
    {
        return new MysqlMigration($this, $tabel, 'create');
    }

    
    public function alterTabel(string $tabel)
    {
        return new MysqlMigration($this, $tabel, 'alter');
    }

    
    public function getTabel(): array
    {
        $statement = $this->pdo->prepare("SHOW TABLES");
        $statement->execute();

        $results = $statement->fetchAll(PDO::FETCH_NUM);
        $results = array_map(fn($result)=> $result[0], $results);

         return $results;
    }

    
    public function hasTable(string $name): bool
    {
        $tabels = $this->getTabel();
        return in_array($name, $tabels);
    }

   
    public function dropTables(): int
    {
        $statement = $this->pdo->prepare("
            SELECT CONCAT('DROP TABLE IF EXISTS `', table_name, '`')
            FROM information_schema.tables
            WHERE table_schema = '{$this->database}';
        ");

        $statement->execute();

        $dropTabel = $statement->fetchAll(PDO::FETCH_NUM);
        $dropTabel = array_map(fn($result) => $result[0], $dropTabel);

        $clauses = [
            'SET FOREIGN_KEY_CHECKS = 0',
            ...$dropTabel,
            'SET FOREIGN_KEY_CHECKS = 1',
        ];

        $statement = $this->pdo->prepare(join(';', $clauses) . ';');

        return $statement->execute();
    }
}