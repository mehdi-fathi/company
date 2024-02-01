<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $productRepository)
    {
        $this->userRepository = $productRepository;
    }

    public function findUserById(int $userId): User
    {
        $user = $this->userRepository->find($userId);

        return $user;
    }
}
