<?php

namespace App\Service;

interface UserContextInterface
{
    /**
     * @param int $userId
     * @return void
     */
    public function setUserRole(int $userId): void;

    /**
     * @return \App\Entity\User
     */
    public function getCurrentUser(): \App\Entity\User;
}
