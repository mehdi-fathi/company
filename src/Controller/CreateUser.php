<?php

namespace App\Controller;

use App\Dto\CreateUserDTO;
use App\Entity\User;
use App\Service\HelperService;
use App\Service\UserContextInterface;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Serializer\SerializerInterface;


/**
 *
 */
#[AsController]
class CreateUser extends AbstractController
{

    /**
     * @param \App\Service\UserService $userService
     * @param \Symfony\Component\Serializer\SerializerInterface $serializer
     * @param \App\Service\UserContextInterface $userContext
     */
    public function __construct(
        private UserService          $userService,
        private SerializerInterface  $serializer,
        private UserContextInterface $userContext,
    )
    {
    }

    /**
     */
    public function __invoke(#[MapRequestPayload] CreateUserDTO $dataDto): JsonResponse
    {
        HelperService::checkHasAccessCreateUserException($this->userContext->getCurrentUserRole());

        $this->userService->save(
            name: $dataDto->name,
            companyId: $dataDto->company_id,
            role: $dataDto->role,
        );

        return new JsonResponse('User has been saved.', Response::HTTP_CREATED);

    }

}
