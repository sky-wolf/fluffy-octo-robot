<?php

namespace Kinnekulle\Support\Storage\Contracts;

interface StorageInterface
{
    public function get($index);
    public function set($index, $val);
    public function all();
    public function exists($index);
    public function unsets($index);
    public function clear();

}