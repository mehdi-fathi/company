<?php

namespace App\Tests\Api;

use App\Entity\Enum\RoleTypeEnum;
use App\Entity\User;
use App\Factory\CompanyFactory;
use App\Factory\UserFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;


class ListUsersTest extends ApiTestCaseCustom
{
    use  ResetDatabase, Factories;

    public function setUp(): void
    {
        parent::setUp();

        UserFactory::createMany(1, [
            'company_id' => 0,
            'name' => 'admin',
            'role' => RoleTypeEnum::SUPER_ADMIN->getValue(),
        ]);

        CompanyFactory::createMany(1);

        $companyId = CompanyFactory::first()->getId();

        UserFactory::createMany(1, [
            'company_id' => $companyId,
            'name' => 'company admin',
            'role' => RoleTypeEnum::COMPANY_ADMIN->getValue(),
        ]);

        UserFactory::createMany(1, [
            'company_id' => $companyId,
            'name' => 'user',
            'role' => RoleTypeEnum::USER->getValue(),
        ]);

        UserFactory::createMany(11);

    }

    public function testListUsersBySuperAdminSuccess(): void
    {
        UserFactory::createMany(11);

        $response = static::createClient()->request('GET', '/api/users' , [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'query' => [
                'page' => 1
            ]
        ]);

        $this->assertMatchesResourceItemJsonSchema(User::class);
        $this->assertResponseIsSuccessful();

        $response = static::createClient()->request('GET', '/api/users' , [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'query' => [
                'page' => 2
            ]
        ]);

        $this->assertMatchesResourceItemJsonSchema(User::class);
        $this->assertResponseIsSuccessful();

    }

    public function testFindUserCompanyByCompanyAdminSuccess(): void
    {

        $response = static::createClient()->request('GET', '/api/users', [
            'headers' => [
                'CurrentUser' => $this->getCompanyAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'query' => [
                'page' => 1
            ]
        ]);

        $this->assertMatchesResourceItemJsonSchema(User::class);

        $this->assertResponseIsSuccessful();

    }

    public function testCantFindUserCompanyByOtherCompanyAdmin(): void
    {
        UserFactory::createMany(2);

        UserFactory::createMany(1, [
            'company_id' => 24,
            'name' => 'company admin 3',
            'role' => RoleTypeEnum::COMPANY_ADMIN->getValue(),
        ]);

        $response = static::createClient()->request('GET', '/api/users', [
            'headers' => [
                'CurrentUser' => UserFactory::findBy(['name' => 'company admin 3'])[0]->getId(),
                'Content-Type' => 'application/ld+json',
            ],
            'query' => [
                'page' => 1
            ]
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

    }
}


