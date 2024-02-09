<?php

namespace App\Service;

use App\Entity\User;

interface UserContextInterface
{
    /**
     * @param int $userId
     * @return void
     */
    public function setCurrentUser(int $userId);

    /**
     * @return \App\Entity\User|null
     */
    public function getCurrentUser(): User|null;

    /**
     * @return string|null
     */
    public function getCurrentUserRole(): string|null;
}
