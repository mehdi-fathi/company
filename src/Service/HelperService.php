<?php

namespace App\Service;

use App\Entity\Enum\RoleTypeEnum;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

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

    /**
     * @param string $currentUserRole
     * @return bool
     */
    public static function isRoleCompanyAdmin(string $currentUserRole): bool
    {
        return ($currentUserRole == RoleTypeEnum::COMPANY_ADMIN->getValue());
    }

    /**
     * @param string|null $currentUserRole
     * @return bool
     */
    public static function HasAccessCreateUser(?string $currentUserRole): bool
    {
        return ($currentUserRole == RoleTypeEnum::SUPER_ADMIN->getValue() || $currentUserRole == RoleTypeEnum::COMPANY_ADMIN->getValue());
    }

    /**
     * @param string|null $currentUserRole
     * @return void
     * @throws \App\Exception\AccessDeniedException
     */
    public static function checkHasAccessCreateUserException(?string $currentUserRole): void
    {
        if (!self::HasAccessCreateUser($currentUserRole)) {
            throw new \App\Exception\AccessDeniedException();
        }
    }
}
