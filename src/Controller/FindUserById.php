<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class FindUserById extends AbstractController
{

    public function __construct(private UserService $userService, private SerializerInterface $serializer)
    {
    }

    public function __invoke($id)
    {
        $user = $this->userService->findUserById($id);

        $serializedData = $this->serializer->serialize($user, 'json', [
            'groups' => 'get',
        ]);

        return new JsonResponse($serializedData, 200, [], true);

        return $user;
    }
}
