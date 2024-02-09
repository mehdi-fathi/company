<?php


namespace App\Repository;


use App\Entity\User;

interface UserRepositoryInterface
{

    /**
     * @param int $userId
     * @param int $companyId
     * @return \App\Repository\User|null
     */
    public function findByUserRelatedCompany(int $userId, int $companyId): ?User;

}
