<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 *
 */
#[\Attribute] class UniqueCompanyName extends Constraint
{
    /**
     * @var string
     */
    public $message = '{{ value }} saved before and you are not able to insert duplicated company name.';


    /**
     * @param array|null $groups
     * @param mixed|null $payload
     */
    #[HasNamedArguments]
    public function __construct(
        array         $groups = null,
        mixed         $payload = null,
    )
    {
        parent::__construct([], $groups, $payload);
    }

    /**
     * @return string
     */
    public function validatedBy(): string
    {
        return UniqueCompanyNameValidator::class;
    }

}
