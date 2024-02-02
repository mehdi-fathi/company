<?php


namespace App\Repository;


use App\Entity\User;

interface UserRepositoryInterface
{

    /**
     * @param int $user_id
     * @param int $company_id
     * @return \App\Repository\User|null
     */
    public function findByUserRelatedCompany(int $user_id, int $company_id): ?User;

}
