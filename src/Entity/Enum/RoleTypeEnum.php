<?php

namespace App\Entity\Enum;


enum RoleTypeEnum: string
{
    case USER = 'ROLE_USER';
    case COMPANY_ADMIN = 'ROLE_COMPANY_ADMIN';
    case SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
