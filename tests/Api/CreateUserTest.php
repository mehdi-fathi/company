<?php

namespace App\Tests\Api;


use App\Entity\Enum\RoleTypeEnum;
use App\Factory\CompanyFactory;
use App\Factory\UserFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;


class CreateUserTest extends ApiTestCaseCustom
{
    use  ResetDatabase, Factories;


    public function testCreateUserSuccess(): void
    {
        CompanyFactory::createMany(1);

        $name = $this->getUserNameValid();

        $response = static::createClient()->request('POST', '/api/users', [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                "name" => $name,
                "company_id" => CompanyFactory::first()->getId(),
                'role' => RoleTypeEnum::USER->getValue(),
            ]

        ]);

        $this->assertResponseIsSuccessful();
        $this->assertSame($name, UserFactory::find(['name' => $name])->getName());

    }

    public function testCreateUserNameValidValidation(): void
    {
        CompanyFactory::createMany(1);

        static::createClient()->request('POST', '/api/users', [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                "name" => "Jax",
                "company_id" => CompanyFactory::first()->getId(),
                'role' => RoleTypeEnum::USER->getValue(),
            ]

        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);

        static::createClient()->request('POST', '/api/users', [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                "name" => "jax",
                "company_id" => CompanyFactory::first()->getId(),
                'role' => RoleTypeEnum::USER->getValue(),
            ]

        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);

        static::createClient()->request('POST', '/api/users', [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                "name" => "steve jobs",
                "company_id" => CompanyFactory::first()->getId(),
                'role' => RoleTypeEnum::USER->getValue(),
            ]

        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNPROCESSABLE_ENTITY);
    }


    public function testCreateUserNameCountValidation(): void
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
                "name" => $this->getUserNameValid(),
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
                "name" => $this->getUserNameValid(),
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
                "name" => $this->getUserNameValid(),
                "company_id" => CompanyFactory::first()->getId()
            ]
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_UNAUTHORIZED);

    }

}


