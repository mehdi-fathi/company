<?php

namespace App\Service;

use App\Entity\Enum\RoleTypeEnum;
use App\Exception\AccessDeniedException;

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
     * @return bool
     */
    public static function HasAccessDeleteUser(?string $currentUserRole): bool
    {
        return ($currentUserRole == RoleTypeEnum::SUPER_ADMIN->getValue());
    }

    /**
     * @param string|null $currentUserRole
     * @return bool
     */
    public static function HasAccessCreateCompany(?string $currentUserRole): bool
    {
        return ($currentUserRole == RoleTypeEnum::SUPER_ADMIN->getValue());
    }

    /**
     * @param string|null $currentUserRole
     * @return void
     * @throws \App\Exception\AccessDeniedException
     */
    public static function checkHasAccessCreateUserException(?string $currentUserRole): void
    {
        if (!self::HasAccessCreateUser($currentUserRole)) {
            throw new AccessDeniedException();
        }
    }

    /**
     * @param string|null $currentUserRole
     * @return void
     * @throws \App\Exception\AccessDeniedException
     */
    public static function checkHasAccessDeleteUserException(?string $currentUserRole): void
    {
        if (!self::HasAccessDeleteUser($currentUserRole)) {
            throw new AccessDeniedException();
        }
    }

    /**
     * @param string|null $currentUserRole
     * @return void
     * @throws \App\Exception\AccessDeniedException
     */
    public static function checkHasAccessCreateCompanyException(?string $currentUserRole): void
    {
        if (!self::HasAccessCreateCompany($currentUserRole)) {
            throw new AccessDeniedException();
        }
    }


    /**
     * @param string|null $msg
     * @return void
     */
    public static function notFoundException(?string $msg = 'Not found'): void
    {
        throw new AccessDeniedException();
    }
}
