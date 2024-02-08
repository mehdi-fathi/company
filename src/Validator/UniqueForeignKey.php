<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 *
 */
#[\Attribute] class UniqueForeignKey extends Constraint
{
    /**
     * @var string
     */
    public $message = '{{ value }} does not exist in {{ entityName }}.';


    /**
     * @param string $foreignKey
     * @param $referencedEntity
     * @param string $entityName
     * @param array|null $groups
     * @param mixed|null $payload
     */
    #[HasNamedArguments]
    public function __construct(
        public string $foreignKey,
        public        $referencedEntity,
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
    public function validatedBy()
    {
        return UniqueForeignKeyValidator::class;
    }

}
