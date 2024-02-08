<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;

use App\Entity\Enum\RoleTypeEnum;
use App\Factory\CompanyFactory;
use App\Factory\UserFactory;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;


class CreateUserTest extends ApiTestCase
{
    use  ResetDatabase, Factories;

    protected function getFixtureLoader()
    {
        // Disable fixture loading
        return null;
    }

    public function testSomething(): void
    {
        UserFactory::createMany(1, [
            'company_id' => 0,
            'name' => 'admin',
            'role' => RoleTypeEnum::SUPER_ADMIN->getValue(),
        ]);

        CompanyFactory::createMany(1);

        $client = static::createClient();

        $response = static::createClient()->request('POST', '/api/users', [
            'headers' => [
                'CurrentUser' => 1,
                'Content-Type' => 'application/ld+json',
            ],
            'json' => [
                "name" => "Mehdi",
                "company_id" => CompanyFactory::first()->getId(),
                "role" => "user"
            ]

        ]);

        // dd($response->getContent());

        $this->assertResponseIsSuccessful();
        // $this->assertJsonContains(['@id' => '/']);
    }
}


