<?php

namespace App\Entity\Enum;


class RoleUserType extends AbstractEnumType
{
    protected string $name = 'role_user';
    protected array $values = [];
    protected static array $options = array(
        RoleTypeEnum::USER,
        RoleTypeEnum::COMPANY_ADMIN,
        RoleTypeEnum::SUPER_ADMIN
    );

    function __init()
    {
        $this->values = self::$options;
    }

    public function getValidValues(): array
    {
        return self::$options;
    }

}
