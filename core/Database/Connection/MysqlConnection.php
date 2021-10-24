<?php

namespace Framework\Database\Connection;

use Framework\Application;
use Framework\Support\DotEnv;
use Pdo;
use InvalidArgumentException;

class MysqlConnection extends Connection
{
    public PDO $pdo;
    private string $database;

    public function __construct()
    {
    
        if( empty(getenv('DATABASE_HOST')) || empty(getenv('DATABASE_DB')) || empty(getenv('DATABASE_USER')))
            throw new InvalidArgumentException('Connection incorrectly configured');

            (new DotEnv())->load();

            $dbDns = 'mysql:host=' . getenv('DATABASE_HOST') . ';dbname=' . getenv('DATABASE_DB') . ';';
            echo $dbDns;
            //$this->pdo = new PDO($dbDns, getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD'));
            $this->pdo = new PDO($dbDns, 'root', 'superSecr3t');
            
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    
    public function pdo(): Pdo
    {
        return $this->pdo;
    }

    
    public function query()
    {

    }


    public function creatTabel(string $tabel)
    {

    }

    
    public function alterTabel(string $tabel)
    {

    }

    
    public function getTabel(): array
    {
        $statement = $this->pdo->prepare("SHOW TABEL");
        $statement->execute();

        $results = $statement->fetchAll(\PDO::FETCH_NUM);
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

        $dropTabel = $statement->fetchAll(\PDO::FETCH_NUM);
        $dropTabel = array_map(fn($result)=> $result[0], $dropTabel);

        $clauses = [
            'SET FOEIGN_KEY_CHECKS = 0',
            ...$dropTabel,
            'SET FOEIGN_KEY_CHECKS = 1',
        ];

        $statement = $this->pdo->prepare(join(';', $clauses) . ';');

        return $statement->execute();
    }
}