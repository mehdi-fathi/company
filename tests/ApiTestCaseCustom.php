<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Enum\RoleTypeEnum;
use App\Factory\UserFactory;

class ApiTestCaseCustom extends ApiTestCase
{


    protected function getSuperAdminId()
    {
        return UserFactory::find(['role' => RoleTypeEnum::SUPER_ADMIN->getValue()])->getId();
    }

    protected function getCompanyAdminId()
    {
        return UserFactory::find(['role' => RoleTypeEnum::COMPANY_ADMIN->getValue()])->getId();
    }

    protected function getUserId()
    {
        return UserFactory::find(['role' => RoleTypeEnum::USER->getValue()])->getId();
    }
}
