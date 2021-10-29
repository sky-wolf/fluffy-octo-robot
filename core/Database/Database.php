<?php
namespace Framework\Database;

class Database
{
    public \PDO $pdo;

    public function __construct()
    {
        $dbDns = 'mysql:host=' . getenv('DATABASE_HOST') . ';dbname=' . getenv('DATABASE_DB') . ';charset=UTF8;';

        $user = getenv('DATABASE_USER');
        $pass = getenv('DATABASE_PASSWORD');

        $this->database = getenv('DATABASE_DB');

        
        try {
            $this->pdo = new \PDO($dbDns, $user, $pass);
        
            if ($this->pdo) {
                echo "Connected to the {$this->database} database successfully!";
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $this->pdo;
    }
}