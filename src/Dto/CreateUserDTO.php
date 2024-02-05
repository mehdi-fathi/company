<?php

namespace App\Dto;


use Symfony\Component\Validator\Constraints as Assert;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiProperty;

/**
 *
 */
class CreateUserDTO
{

    #[ApiProperty(default: "Mehdi")]
    #[Assert\NotBlank(message: "Name cannot be blank.")]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 100, exactMessage: "Name cannot be blank.")]
    public string $name;
    /**
     * @var int
     */
    #[ApiProperty(default: 1)]
    public int $company_id;

    /**
     * @var string
     */

    #[ApiProperty(default: 'user', example: ['user', 'admin', 'super_admin'])]
    public string $role;
}
