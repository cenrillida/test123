<?php

namespace DissertationCouncils\Exceptions;

/**
 * Exception used for user not found situation
 */
class UserNotFoundException extends Exception
{
    public function __construct($message = "������������ � ������ ������� �� ������.", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
