<?php

namespace App\Service;

use App\Entity\Company;
use App\Entity\Enum\RoleTypeEnum;
use App\Entity\User;
use App\Repository\CompanyRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 *
 */
final class CompanyService
{

    /**
     * @param \App\Repository\CompanyRepository $companyRepository
     */
    public function __construct(private CompanyRepository $companyRepository)
    {
    }

    /**
     * @param int $companyId
     * @return \App\Entity\Company|null
     */
    public function findByCompanyId(int $companyId): Company|null
    {
        $companyData = $this->companyRepository->find($companyId);

        return $companyData;
    }

    /**
     * @param string $name
     * @return void
     */
    public function save(string $name)
    {
        $this->companyRepository->create($name);
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        return $this->companyRepository->delete($id);
    }
}
