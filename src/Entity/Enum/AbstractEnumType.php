<?php

namespace App\Entity\Enum;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

abstract class AbstractEnumType extends Type
{

    protected string $schema = "public";
    protected string $name;
    protected array $values = array();


    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $this->schema . ".\"" . $this->getName() . "\"";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): mixed
    {
        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): mixed
    {
        if (!in_array($value, $this->getValidValues())) {
            throw new \InvalidArgumentException("Invalid '" . $this->name . "' value.");
        }
        return $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }

    public function getValidValues(): array
    {
        return $this->values;
    }

}

