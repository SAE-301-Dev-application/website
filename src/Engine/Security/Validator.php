<?php

namespace MvcLite\Engine\Security;

/**
 * Validation class.
 *
 * @author belicfr
 */
class Validator
{
    /** Current rules validation state. */
    private bool $validationState;

    /** Current rules validation error messages. */
    private array $errors;

    public function __construct()
    {
        $this->validationState = true;
        $this->errors = [];
    }

    /**
     * Returns if all given fields are filled:
     *  - not nulls
     *  - not empty strings
     *
     * @param array $values Values to validate
     * @return bool Current validator state
     */
    public function required(array $values): bool
    {
        foreach ($values as $value)
        {
            if ($value === null || !strlen($value))
            {
                return $this->validationState = false;
            }
        }

        return $this->validationState &= true;
    }
}