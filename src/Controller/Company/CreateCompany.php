<?php

namespace App\Controller\Company;

use App\Dto\CreateCompanyDTO;
use App\Dto\CreateUserDTO;
use App\Entity\Enum\RoleTypeEnum;
use App\Response\ApiResponse;
use App\Service\CompanyService;
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
class CreateCompany extends AbstractController
{

    /**
     * @param \App\Service\CompanyService $companyService
     * @param \Symfony\Component\Serializer\SerializerInterface $serializer
     * @param \App\Service\UserContextInterface $userContext
     */
    public function __construct(
        private CompanyService       $companyService,
        private SerializerInterface  $serializer,
        private UserContextInterface $userContext
    )
    {
    }

    /**
     * @throws \App\Exception\AccessDeniedException
     */
    public function __invoke(#[MapRequestPayload] CreateCompanyDTO $dataDto): JsonResponse
    {
        HelperService::checkHasAccessCreateCompanyException($this->userContext->getCurrentUserRole());

        if (HelperService::isRoleCompanyAdmin($this->userContext->getCurrentUserRole())) {
            $dataDto->role = RoleTypeEnum::USER->getValue();
        }

        $this->companyService->save(
            name: $dataDto->name
        );

        $res = ApiResponse::getResponse(true, 'Company has been saved successfully.');

        return new JsonResponse($res, Response::HTTP_CREATED);

    }

}
