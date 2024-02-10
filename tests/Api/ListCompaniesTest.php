<?php

namespace App\Tests\Api;

use App\Entity\Company;
use App\Factory\CompanyFactory;
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


