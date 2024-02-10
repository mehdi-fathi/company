<?php

namespace App\Tests\Api;

use App\Factory\CompanyFactory;
use App\Factory\UserFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;


class DeleteUserTest extends ApiTestCaseCustom
{
    use  ResetDatabase, Factories;

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

}


