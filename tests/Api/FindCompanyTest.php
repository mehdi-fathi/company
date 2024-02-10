<?php

namespace App\Tests\Api;

use App\Entity\Company;
use App\Factory\CompanyFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;


class FindCompanyTest extends ApiTestCaseCustom
{
    use  ResetDatabase, Factories;


    public function testFindCompanyById(): void
    {
        $companyId = CompanyFactory::first()->getId();

        $response = static::createClient()->request('GET', '/api/companies/' . $companyId, [
            'headers' => [
                'CurrentUser' => $this->getCompanyAdminId(),
                'Content-Type' => 'application/ld+json',
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertMatchesResourceItemJsonSchema(Company::class);

    }


}


