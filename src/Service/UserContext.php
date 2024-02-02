<?php
// src/Service/UserContext.php

namespace App\Service;

use App\Entity\Enum\RoleTypeEnum;
use App\Entity\User;

/**
 *
 */
class UserContext implements UserContextInterface
{
    private User $currentUser;

    /**
     * @param \App\Service\UserService $userService
     */
    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * @param int $userId
     * @return void
     */
    public function setUserRole(int $userId): void
    {
        $this->currentUser = $this->userService->findUserById($userId);
    }

    /**
     * @return \App\Entity\User
     */
    public function getCurrentUser(): User
    {
        return $this->currentUser;
    }
}
