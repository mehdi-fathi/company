<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

use App\Entity\Enum\RoleTypeEnum;
use App\Factory\CompanyFactory;
use App\Factory\UserFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;


class CreateUserTest extends ApiTestCase
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

    public function testCreateUserSuccess(): void
    {
        CompanyFactory::createMany(1);

        $response = static::createClient()->request('POST', '/api/users', [
            'headers' => [
                'CurrentUser' => 1,
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                "name" => "Mehdi",
                "company_id" => CompanyFactory::first()->getId(),
                'role' => RoleTypeEnum::USER->getValue(),
            ]

        ]);


        $this->assertResponseIsSuccessful();
    }

    public function testCreateUserNameValidation(): void
    {
        CompanyFactory::createMany(1);

        static::createClient()->request('POST', '/api/users', [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                "name" => "j",
                "company_id" => CompanyFactory::first()->getId(),
                'role' => RoleTypeEnum::USER->getValue(),
            ]

        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCreateUserCheckHasCompanyIdValidation(): void
    {

        static::createClient()->request('POST', '/api/users', [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                "name" => "mehdi",
                "company_id" => 999,
                'role' => RoleTypeEnum::USER->getValue(),
            ]

        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function testCreateUserCompanyUserValidation(): void
    {
        static::createClient()->request('POST', '/api/users', [
            'headers' => [
                'CurrentUser' => $this->getCompanyAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                "name" => "mehdi",
                "company_id" => CompanyFactory::first()->getId()
            ]

        ]);

        $this->assertResponseIsSuccessful();
    }

    public function testCheckUserCantRequest(): void
    {
        static::createClient()->request('POST', '/api/users', [
            'headers' => [
                'CurrentUser' => $this->getUserId(),
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                "name" => "mehdi",
                "company_id" => CompanyFactory::first()->getId()
            ]
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


