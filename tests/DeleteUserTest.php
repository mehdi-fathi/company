<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

use App\Entity\Enum\RoleTypeEnum;
use App\Factory\CompanyFactory;
use App\Factory\UserFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;


class DeleteUserTest extends ApiTestCase
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
    }

    public function testDeleteUserBySuperAdmin(): void
    {
        CompanyFactory::createMany(1);

        $userId = $this->getUserId();

        $response = static::createClient()->request('DELETE', '/api/users/' . $userId, [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertSame([], UserFactory::findBy(['id' => $userId]));

    }

    public function testOthersCantAccess(): void
    {
        CompanyFactory::createMany(1);

        $userId = $this->getUserId();

        $response = static::createClient()->request('DELETE', '/api/users/' . $userId, [
            'headers' => [
                'CurrentUser' => $this->getCompanyAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

    }

    private function getSuperAdminId()
    {
        return UserFactory::find(['role' => RoleTypeEnum::SUPER_ADMIN->getValue()])->getId();
    }

    private function getCompanyAdminId()
    {
        return UserFactory::find(['role' => RoleTypeEnum::COMPANY_ADMIN->getValue()])->getId();
    }

    private function getUserId()
    {
        return UserFactory::find(['role' => RoleTypeEnum::USER->getValue()])->getId();
    }
}


