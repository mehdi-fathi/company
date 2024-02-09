<?php


namespace App\Validator\User;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 *
 */
class ValidUserNameValidator extends ConstraintValidator
{
    /**
     * @param $value
     * @param \Symfony\Component\Validator\Constraint $constraint
     * @return void
     */
    public function validate($value, Constraint $constraint)
    {
        $patternMain = '/^[a-zA-Z ]+$/';
        $patternUppercase = '/[A-Z]+/';
        $patternSpace = '/\s/';

        // Perform the validation using preg_match
        if (!preg_match($patternMain, $value) || !preg_match($patternSpace, $value) || !preg_match($patternUppercase, $value)) {

            // return false; // Invalid input
            $this->context->buildViolation($constraint->message)
                ->setParameter("{{ value }}", $value)
                ->addViolation();
        }
    }
}
