<?php

namespace App\Validator\Company;

use App\Validator\HasNamedArguments;
use Symfony\Component\Validator\Constraint;

/**
 *
 */
#[\Attribute] class ExistCompanyForeignKey extends Constraint
{
    /**
     * @var string
     */
    public $message = '{{ value }} does not exist in {{ entityName }}.';


    /**
     * @param string $foreignKey
     * @param string $entityName
     * @param array|null $groups
     * @param mixed|null $payload
     */
    #[HasNamedArguments]
    public function __construct(
        public string $foreignKey,
        public string $entityName,
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
        return ExistCompanyForeignKeyValidator::class;
    }

}
