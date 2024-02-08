<?php

namespace App\Dto;


use Symfony\Component\Validator\Constraints as Assert;

use ApiPlatform\Metadata\ApiProperty;

/**
 *
 */
class CreateCompanyDTO
{

    #[ApiProperty(default: "Mehdi")]
    #[Assert\NotBlank(message: "Name cannot be blank.")]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 100, exactMessage: "Name cannot be blank.")]
    public string $name;

}
