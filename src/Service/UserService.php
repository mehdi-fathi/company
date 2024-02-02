<?php

namespace App\Service;

use App\Entity\Enum\RoleTypeEnum;
use App\Entity\User;
use App\Repository\UserRepository;

/**
 *
 */
final class UserService
{
    /**
     * @var \App\Repository\UserRepository
     */
    private UserRepository $userRepository;

    /**
     * @param \App\Repository\UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param int $userId
     * @return \App\Entity\User
     */
    public function findUserById(int $userId): User
    {
        $user = $this->userRepository->find($userId);

        return $user;
    }

    /**
     * @param int $userId
     * @param string $currentUserRole
     * @param string $currentUserCompanyId
     * @return \App\Entity\User
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findUserByIdBasedRole(int $userId, string $currentUserRole, string $currentUserCompanyId): User
    {
        if (HelperService::isRoleSuperAdmin($currentUserRole)) {
            $userData = $this->userRepository->find($userId);
        } else {
            $userData = $this->userRepository->findByUserRelatedCompany($userId, $currentUserCompanyId);
        }

        return $userData;
    }
}
