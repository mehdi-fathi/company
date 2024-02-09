<?php

namespace App\Dto;


use ApiPlatform\Metadata\ApiProperty;
use App\Validator as AcmeAssert;
use Symfony\Component\Validator\Constraints as Assert;


/**
 *
 */
class CreateUserDTO
{

    #[ApiProperty(default: "Mehdi")]
    #[Assert\NotBlank(message: "Name cannot be blank.")]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 100, exactMessage: "Name cannot be blank.")]
    #[AcmeAssert\User\ValidUserName()]
    public string $name;

    /**
     * @var int
     */
    #[ApiProperty(default: 1)]
    #[AcmeAssert\Company\ExistCompanyForeignKey(foreignKey: "id", entityName: "companies")]
    public int $company_id;

    /**
     * @var string
     */

    #[ApiProperty(default: 'user', example: ['user', 'company_admin', 'super_admin', null])]
    #[Assert\Choice(choices: ['user', 'company_admin', 'super_admin', null])]
    public string $role;
}
