<?php

namespace App\Story;

use App\Entity\Enum\RoleTypeEnum;
use App\Factory\UserFactory;
use App\Repository\CompanyRepository;
use Faker\Provider\Company;
use Faker\Provider\Person;
use Zenstruck\Foundry\Story;

/**
 *
 */
final class DefaultUserStory extends Story
{

    /**
     * @param \App\Repository\CompanyRepository $companyRepository
     */
    public function __construct(private CompanyRepository $companyRepository)
    {
    }

    /**
     * @return void
     */
    public function build(): void
    {
        UserFactory::createMany(1, [
            'company_id' => 0,
            'name' => 'admin',
            'role' => RoleTypeEnum::SUPER_ADMIN->getValue(),
        ]);

        UserFactory::createMany(1, [
            'company_id' => $this->companyRepository->findBy([], [], 1, 1)[0]->getId(),
            'name' => Person::firstNameMale(),
            'role' => RoleTypeEnum::COMPANY_ADMIN->getValue(),
        ]);

        UserFactory::createMany(1, [
            'company_id' => $this->companyRepository->findBy([], [], 1, 2)[0]->getId(),
            'name' => Person::firstNameFemale(),
            'role' => RoleTypeEnum::COMPANY_ADMIN->getValue(),
        ]);

        UserFactory::createMany(10, [
            'company_id' => $this->companyRepository->findBy([], [], 1, 1)[0]->getId(),
            // 'name' => Person::firstNameFemale(),
            'role' => RoleTypeEnum::USER->getValue(),
        ]);

        UserFactory::createMany(10, [
            'company_id' => $this->companyRepository->findBy([], [], 1, 2)[0]->getId(),
            // 'name' => Person::firstNameFemale(),
            'role' => RoleTypeEnum::USER->getValue(),
        ]);

        UserFactory::createMany(5, [
            'company_id' => $this->companyRepository->findBy([], [], 1, rand(2, 5))[0]->getId(),
            'name' => Person::firstNameFemale(),
            'role' => RoleTypeEnum::USER->getValue(),
        ]);
    }
}
