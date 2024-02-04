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
    private ?User $currentUser = null;

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
    public function setCurrentUser(int $userId): void
    {
        $this->currentUser = $this->userService->findUserById($userId);
    }

    /**
     * @return \App\Entity\User|null
     */
    public function getCurrentUser(): User|null
    {
        return $this->currentUser;
    }

    /**
     * @return string|null
     */
    public function getCurrentUserRole(): string|null
    {
        return $this->getCurrentUser()?->getRole();
    }


}
