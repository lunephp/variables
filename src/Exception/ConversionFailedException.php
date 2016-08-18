<?php


namespace Lune\Variables\Exception;

use Exception;

class ConversionFailedException extends Exception
{
    public function __construct($input)
    {

        parent::__construct("Conversion failed, only an array or null can be converted to VariableBag.");
    }
}