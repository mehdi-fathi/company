<?php

namespace App\Entity\Enum;


class RoleUserType extends AbstractEnumType
{
    protected string $name = 'role_user';
    protected array $values = [];
    protected array $options = [];

    function __init()
    {
    }

    public function getValidValues(): array
    {
        $this->options[] = RoleTypeEnum::USER->getValue();
        $this->options[] = RoleTypeEnum::COMPANY_ADMIN->getValue();
        $this->options[] = RoleTypeEnum::SUPER_ADMIN->getValue();
        return $this->options;
    }

}
