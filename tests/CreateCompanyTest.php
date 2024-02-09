<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

use App\Entity\Enum\RoleTypeEnum;
use App\Factory\CompanyFactory;
use App\Factory\UserFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;


class CreateCompanyTest extends ApiTestCaseCustom
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

    public function testCreateCompanySuccess(): void
    {
        $name = "Apple 2354";

        $response = static::createClient()->request('POST', '/api/companies', [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                "name" => $name,
            ]

        ]);

        $this->assertResponseIsSuccessful();

        $this->assertSame($name, CompanyFactory::find(['name' => $name])->getName());
    }

    public function testCheckAdminCanCreateCompany(): void
    {
        $name = "Apple 2354";

        $response = static::createClient()->request('POST', '/api/companies', [
            'headers' => [
                'CurrentUser' => $this->getCompanyAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                "name" => $name,
            ]

        ]);
        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);


    }


    public function testCreateCompanyValidationNameCount(): void
    {
        $name = "Ap";

        $response = static::createClient()->request('POST', '/api/companies', [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                "name" => $name,
            ]

        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);

    }

    public function testCreateCompanyValidationNameUnique(): void
    {
        $name = "Apple 2354";

        CompanyFactory::createMany(1,['name' => $name]);

        $response = static::createClient()->request('POST', '/api/companies', [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                "name" => $name,
            ]

        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);

    }


    public function testCreateCompanyValidationNameBlank(): void
    {

        $response = static::createClient()->request('POST', '/api/companies', [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
            ]

        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);

    }


}


