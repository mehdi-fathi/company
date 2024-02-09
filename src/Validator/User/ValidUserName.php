<?php

namespace App\Validator\User;

use Symfony\Component\Validator\Constraint;

/**
 *
 */
#[\Attribute] class ValidUserName extends Constraint
{
    public $message = '{{ value }} must contain only letters, spaces, and at least one uppercase letter.';

    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return ValidUserNameValidator::class;
    }

}
