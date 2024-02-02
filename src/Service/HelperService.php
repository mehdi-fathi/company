<?php

namespace App\Service;

use App\Entity\Enum\RoleTypeEnum;

/**
 *
 */
final class HelperService
{

    /**
     * @param string $currentUserRole
     * @return bool
     */
    public static function isRoleSuperAdmin(string $currentUserRole): bool
    {
        return ($currentUserRole == RoleTypeEnum::SUPER_ADMIN->getValue());
    }

}
