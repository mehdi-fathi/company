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


class FindCompanyTest extends ApiTestCaseCustom
{
    use  ResetDatabase, Factories;


    public function testFindCompanyById(): void
    {
        $companyId = CompanyFactory::first()->getId();

        $response = static::createClient()->request('GET', '/api/companies/' . $companyId, [
            'headers' => [
                'CurrentUser' => 1,
                'Content-Type' => 'application/ld+json',
            ]
        ]);

        $this->assertResponseIsSuccessful();

        $this->assertMatchesResourceItemJsonSchema(Company::class);

    }


}


