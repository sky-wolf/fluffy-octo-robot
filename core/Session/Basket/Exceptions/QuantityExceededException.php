<?php

namespace Kinnekulle\Basket\Exceptions;

use Exception;


class QuantityExceededException extends Exception
{
    protected $message = 'You have aded the maximum stock for this item';
}