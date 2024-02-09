<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

use App\Entity\Company;
use App\Entity\Enum\RoleTypeEnum;
use App\Entity\User;
use App\Factory\CompanyFactory;
use App\Factory\UserFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;


class ListCompaniesTest extends ApiTestCaseCustom
{
    use  ResetDatabase, Factories;

    public function testListCompanies(): void
    {
        CompanyFactory::createMany(11);

        $response = static::createClient()->request('GET', '/api/companies', [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'query' => [
                'page' => 1
            ]
        ]);

        $this->assertMatchesResourceItemJsonSchema(Company::class);
        $this->assertResponseIsSuccessful();

        $response = static::createClient()->request('GET', '/api/companies', [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
            'query' => [
                'page' => 2
            ]
        ]);

        $this->assertMatchesResourceItemJsonSchema(Company::class);
        $this->assertResponseIsSuccessful();

    }

}


