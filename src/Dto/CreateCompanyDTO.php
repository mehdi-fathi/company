<?php

namespace App\Dto;


use Symfony\Component\Validator\Constraints as Assert;

use ApiPlatform\Metadata\ApiProperty;
use App\Validator as AcmeAssert;

/**
 *
 */
class CreateCompanyDTO
{

    #[ApiProperty(default: "Apple")]
    #[Assert\NotBlank(message: "Name cannot be blank.")]
    #[Assert\Length(min: 5, max: 100, exactMessage: "Name cannot be blank.")]
    #[AcmeAssert\UniqueCompanyName()]
    public string $name;

}
