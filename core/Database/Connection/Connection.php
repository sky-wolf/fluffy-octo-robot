<?php

namespace Framework\Database\Connection;

use Pdo;

abstract class Connection
{
    /**
     * Get the underliying Pdo instance for this connection
    */
    abstract public function pdo(): Pdo;

    /**
     * Start a new query 
     */
    abstract public function query();


    /**
     * Start a new migration to ad a table
     */
    abstract public function createTable(string $tabel);

    /**
     * 
     */
    abstract public function alterTabel(string $tabel);

    /**
     * Returns a list of the tabel names
     */
    abstract public function getTabel(): array;

    /**
     * find out if a tabel exist
     */
    abstract public function hasTable(string $name): bool;

    /**
     * find out if migrations has row exist
     */
    abstract public function inMigration(string $name): bool;

    /**
     * Drop all tables in vurrent database
     */
    abstract public function dropTables(): int;
}
