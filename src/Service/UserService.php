<?php

namespace App\Service;

use App\Entity\Enum\RoleTypeEnum;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 *
 */
final class UserService
{

    /**
     * @param \App\Repository\UserRepository $userRepository
     * @param \App\Service\CompanyService $companyService
     */
    public function __construct(private UserRepository $userRepository, private CompanyService $companyService)
    {
    }

    /**
     * @param int $userId
     * @return \App\Entity\User|null
     */
    public function findUserById(int $userId): ?User
    {
        $user = $this->userRepository->find($userId);

        return $user;
    }

    /**
     * @param int $userId
     * @param string $currentUserRole
     * @param string $currentUserCompanyId
     * @return \App\Entity\User|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findUserByIdBasedRole(int $userId, string $currentUserRole, string $currentUserCompanyId): ?User
    {
        if (HelperService::isRoleSuperAdmin($currentUserRole)) {
            $userData = $this->userRepository->find($userId);
        } else {
            $userData = $this->userRepository->findByUserRelatedCompany($userId, $currentUserCompanyId);
        }

        return $userData;
    }

    /**
     */
    public function paginateUsers(string $currentUserRole, string $currentUserCompanyId, int $page = 1)
    {
        if (HelperService::isRoleSuperAdmin($currentUserRole)) {
            $userData = $this->userRepository->getAllPaginated($page);
        } else {
            $userData = $this->userRepository->getUserRelatedCompanyPaginated($currentUserCompanyId, $page);
        }

        return $userData;
    }

    /**
     * @param string $name
     * @param int $companyId
     * @param string $role
     * @return bool
     */
    public function save(string $name, int $companyId, string $role): bool
    {
        $company = $this->companyService->findByCompanyId($companyId);
        if (!empty($company)) {
            $this->userRepository->create($name, $companyId, $role);
            return true;
        }
        return false;

    }

    /**
     * @param $id
     * @return void
     */
    public function delete($id)
    {
        $this->userRepository->delete($id);
    }
}
