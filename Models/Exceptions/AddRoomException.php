<?php
namespace Models\Exceptions;

use Exception;

class AddRoomException extends Exception
{
    private $_problemArray;

    public function __construct(
        $message,
        $problemArray = [],
        $code = 0,
        Exception $previous = null
    ) {
        parent::__construct($message, $code, $previous);

        $this->_problemArray = $problemArray;
    }

    public function getExceptionArray()
    {
        return $this->_problemArray;
    }
}