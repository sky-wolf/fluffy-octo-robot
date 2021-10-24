<?php

namespace Framwork\Database\QueryBuilder;

use Framework\Database\Connection\Connection;
use Framework\Database\Exception\QueryException;
use Pdo;
use PdoStatement;

abstract class QueryBuilder
{
    protected string $type;
    protected array $columns;
    protected string $table;
    protected int $limit;
    protected int $offset;
    protected array $Values;
    protected array $wheres = [];
    
    /**
     * Fetch all rows matching the curent query.
     */
    public function all() : array
    {
        $statement = $this->prepare();
        $statement->execute($this->getWhereValues());

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    protected function getWhereValues() : array
    {
        $Values=[];

        if( count($this->wheres) === 0 )
            return $Values;

        foreach ($this->wheres as $where)
        {
            $Values[$where[0]] = $where[2];
        }

        return $Values;
    }

    /**
     * Prepare a query aginst a particular connection
     */
    public function prepare($sql) : PDOStatement
    {
        $query = '';

        if($this->type === 'select')
        {
            $query = $this->compileSelect($query);
            $query = $this->compileWheres($query);
            $query = $this->compileLimit($query);

        }

        if($this->type === 'insert')
        {
            $query = $this->compileInsert($query);
        }

        if(enty($query))
            throw new QueryException('Unrecognised query type');


        return $this->connection->pdo->prepare($query);
    }

    /**
     * Add select clause to query
     */
    protected function compileSelect($query): string
    {
        $jountColumns = join(', ', $this->columns);

        $query .= " SELECT  {$jountColumns} FROME {$this->table}";

        return  $query;
    }

    /**
     * Add limit and offset clauses to the query
     */
    protected function compileLimit($query): string
    {
        if(isset($this->limit))
            $query .= " LIMIT  {$this->limit}";

        if(isset($this->offset))
            $query .= " OFFSET  {$this->offset}";

        return  $query;
    }

    protected function compileWheres($query): string
    {
        if( count($this->wheres) === 0 )
            return $Values;

        foreach($this->wheres as $i => $where)
        {
            if($i > 0)
                $query .= ', ';
            
            [$column, $comparator, $value]= $where;

            $query .= " {$column} {$comparator} :{$column}";
        }

        return  $query;
    }

    /**
     * Add insert clause to the query
     */
    protected function compileInsert($query): string
    {
        $jountColumns = join(', ', $this->columns);
        $jountPlacehollders = join(', ', array_map(fn($column) => ":{$column}", $this->columns));

        $query .= " INSERT INTO {$this->table} {$jountColumns} VALUE {$jountPlacehollders}";
        
        return  $query;
    }

    /**
     * Fetch the first row matching the current query
     */
    public function first(): array
    {
        $statement = $this->take(1)->prepare();
        $statement->execute($this->getWhereValues());

        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        if(count($result) === 1)
            return $result[0];

        return null;
    }

    /**
     * Limit a set of query results so that it's possible
     * to fetch a single or limited batch of rows
     */
    public function take(int $limit, int $offset = 0): static
    {
        $this->limit= $limit;
        $this->offset=$offset;

        return $this;
    }

    /**
     * Indicate which table the query is targetting
     */
    public function from(string $table): static
    {
        $this->tabel = $table;
        return $this;
    }

    /**
     * Indicate the query type is a "select" and remember 
     * which fields should be returned by the query
     */
    public function select(mixed $columns = '*'): static
    {
        if(is_string($columns))
            $columns = [$columns];

        $this->type = 'select';
        $this->comlumns = $columns;

        return $this;
    }

    /**
     * Insert a row of data into the table specified in the query
     * and return the number of affected rows
     */
    public function insert(array $columns, array $values): int
    {
        $this->type = 'insert';
        $this->columns = $columns;
        $this->values = $values;

        $statement = $this->prepare();

        return $statement->execute($values);
    }

    public function where(string $column, mixed $comparator, mixed $value = null): static
    {
        if (is_null($value) && !is_null($comparator)) {
            array_push($this->wheres, [$column, '=', $comparator]);
        } else {
            array_push($this->wheres, [$column, $comparator, $value]);
        }

        return $this;
    }
}