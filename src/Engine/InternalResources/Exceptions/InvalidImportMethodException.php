<?php

namespace MvcLite\Engine\InternalResources\Exceptions;

use MvcLite\Engine\MvcLiteException;

class InvalidImportMethodException extends MvcLiteException
{
    public function __construct()
    {
        parent::__construct();

        $this->code = "MVCLITE_INVALID_IMPORT_METHOD";
        $this->message = "The given import method does not longer supported or not exist.";
    }
}