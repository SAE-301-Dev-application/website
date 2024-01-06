<?php

namespace MvcLite\Router\Engine\Exceptions;

use MvcLite\Engine\MvcLiteException;

class UndefinedFileException extends MvcLiteException
{
    public function __construct(string $fileInput)
    {
        parent::__construct();

        $this->code = "MVCLITE_UNDEFINED_FILE";
        $this->message = "$fileInput file does not longer exist.";
    }
}