<?php

namespace Framework\Database;
use Framework\Database\Connection\Connection;
use Framework\Database\Exception\ConnectionException;
use Framework\Config\DotEnv;
use Framework\Application;


class Factory
{
    protected array $connectors;

    public function addConnector(string $alias, Closure $connector): static
    {
        $this->connectors[$alias] = $connector;
        return $this;
    }

    public function connect(array $config)
    {
        
        (new DotEnv())->load();

        if(null !== getenv('DATABASE_Connect'))
        {
            throw new ConnectionException("type is not defined");
            
        }
        $type = getenv('DATABASE_Connect');

        if(isset($this->connectors[$typ]))
            return $this->connectors[$typ]();
        
        throw new ConnectionException("unrecognised type");
        
    }
}