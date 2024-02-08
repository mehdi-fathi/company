<?php

namespace App\Controller\User;

use App\Dto\CreateUserDTO;
use App\Entity\Enum\RoleTypeEnum;
use App\Response\ApiResponse;
use App\Service\HelperService;
use App\Service\UserContextInterface;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
     * @throws \App\Exception\AccessDeniedException
     */
    public function __invoke(#[MapRequestPayload] CreateUserDTO $dataDto): JsonResponse
    {
        HelperService::checkHasAccessCreateUserException($this->userContext->getCurrentUserRole());

        if (HelperService::isRoleCompanyAdmin($this->userContext->getCurrentUserRole())) {
            $dataDto->role = RoleTypeEnum::USER->getValue();
        }

        $out = $this->userService->save(
            name: $dataDto->name,
            companyId: $dataDto->company_id,
            role: $dataDto->role,
        );
        $msg = 'false';

        if ($out) {
            $msg = 'User has been saved successfully.';
        }

        $res = ApiResponse::getResponse($out, $msg);

        return new JsonResponse($res, Response::HTTP_CREATED);

    }

}
