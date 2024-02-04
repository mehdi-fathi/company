<?php

namespace App\Dto;


use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 */
class createUserDTO
{

    /**
     * @var string
     *
     *
     * @Assert\NotBlank(message="Name cannot be blank.")
     * @Assert\Length(min=3, max=255, minMessage="Name must be at least 3 characters long.")
     */
    public string $name;
    /**
     * @var int
     */
    public int $companyId;

    /**
     * @var string
     */
    public string $role;
}
