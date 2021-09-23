<?php

namespace app\core\database;
use app\core\Application;
use app\core\Config\DotEnv;


class Database
{
    public \PDO $pdo;

    public function __construct()
    {
        $absolutePathToEnvFile = Application::$ROOT_DIR . '/.env';
        (new DotEnv($absolutePathToEnvFile))->load();

        $dbDns = 'mysql:host=' . getenv('DATABASE_HOST') . ';dbname=' . getenv('DATABASE_DB') . ';';
        
        $this->pdo = new \PDO($dbDns, getenv('DATABASE_USER'), getenv('DATABASE_PASSWORD'));
        
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    protected function creatMigrationsTabel()
    {
        $this->pdo->exec("CREAT TABEL IF NOT EXISTS migrations(
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )ENGINE=INNODB");
    }

    protected function getAppliedMigrations()
    {
        $statement = $this->pdo->prepare("SELECT migration FROM migrations");
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    protected function saveMigrations(array $newmigrations)
    {
        $str = implode(',', array_map(fn($m) => "('$m')", $newmigrations));

        $statement = $this->pdo->prepare("INSERT INTO migrations (migration) VALUES
            $str
        ");
        $statement->execute();
    }

    public function preparre($sql):\PDOStatement
    {
        return $this->pdo->prepare($sql);
    }

    public function log($massage)
    {
        echo "[" . date("Y-m-d H:i:s") . "]" . $massage . PHP_EOL;
    }

    public function applyMigrations()
    {
        $dir = Application::$ROOT_DIR . '/core/migrations';

        $this->creatMigrationsTabel();

        $appliedM = $this->getAppliedMigrations();

        $newMigrations = [];

        $files = scandir($dir);

        $toApply = array_diff( $files, $appliedM );

        foreach($toApply as $migration)
        {
            if($migration === '.' || $migration === '..')
                continue;

            require_once $dir . '$migration';

            $classN = pathinfo($migration, PATHINFO_FILENAME);

            $instance = new $classN();
            
            $this_log("Applying migration $migration");

            $instance->up();

            $this_log("Applied migration $migration");

            $newMigrations = $migration;
        }

        if(!empty($newMigrations))
        {
            $this->saveMigrations($newMigrations);
        }else
        {
            $this_log("There are no migrations to apply");
        }
    }
}