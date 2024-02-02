<?php

namespace App\Entity\Enum;


enum RoleTypeEnum: string
{
    case USER = 'user';
    case COMPANY_ADMIN = 'company_admin';
    case SUPER_ADMIN = 'super_admin';

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
