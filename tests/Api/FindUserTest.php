<?php

namespace App\Tests\Api;

use App\Entity\Enum\RoleTypeEnum;
use App\Entity\User;
use App\Factory\UserFactory;
use Symfony\Component\HttpFoundation\Response;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;


class FindUserTest extends ApiTestCaseCustom
{
    use  ResetDatabase, Factories;


    public function testFindUserBySuperAdminSuccess(): void
    {

        $response = static::createClient()->request('GET', '/api/users/' . $this->getUserId(), [
            'headers' => [
                'CurrentUser' => $this->getSuperAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertMatchesResourceItemJsonSchema(User::class);

        $this->assertResponseIsSuccessful();

    }

    public function testFindUserCompanyByCompanyAdminSuccess(): void
    {

        $response = static::createClient()->request('GET', '/api/users/' . $this->getUserId(), [
            'headers' => [
                'CurrentUser' => $this->getCompanyAdminId(),
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertMatchesResourceItemJsonSchema(User::class);

        $this->assertResponseIsSuccessful();

    }

    public function testCantFindUserCompanyByOtherCompanyAdmin(): void
    {
        UserFactory::createMany(1, [
            'company_id' => 25,
            'name' => 'company admin 2',
            'role' => RoleTypeEnum::COMPANY_ADMIN->getValue(),
        ]);

        $response = static::createClient()->request('GET', '/api/users/' . $this->getUserId(), [
            'headers' => [
                'CurrentUser' => UserFactory::findBy(['name' => 'company admin 2'])[0]->getId(),
                'Content-Type' => 'application/ld+json',
            ],
        ]);

        $this->assertResponseStatusCodeSame(Response::HTTP_NOT_FOUND);

    }
}


