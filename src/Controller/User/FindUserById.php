<?php

namespace App\Controller\User;

use App\Response\ApiResponse;
use App\Serializer\ApiResponseSerializer;
use App\Service\HelperService;
use App\Service\UserContextInterface;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class FindUserById extends AbstractController
{

    public function __construct(
        private UserService          $userService,
        private SerializerInterface  $serializer,
        private UserContextInterface $userContext
    )
    {
    }

    /**
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function __invoke(int $id)
    {
        $currentUser = $this->userContext->getCurrentUser();
        $user = $this->userService->findUserByIdBasedRole(
            $id,
            $currentUser->getRole(),
            $currentUser->getCompanyId(),
        );

        if(empty($user)){
            HelperService::notFoundException();
        }

        $res = ApiResponse::getResponse(true, '', $user);

        $serializedData = $this->serializer->serialize($res, 'json', [
            'groups' => 'get',
        ]);

        return new JsonResponse($serializedData, 200, [], true);

    }
}
