<?php

namespace App\Controller\Company;

use App\Response\ApiResponse;
use App\Serializer\ApiResponseSerializer;
use App\Service\CompanyService;
use App\Service\UserContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;

#[AsController]
class FindCompanyById extends AbstractController
{

    public function __construct(
        private CompanyService       $companyService,
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
        $company = $this->companyService->findByCompanyId(
            $id,
        );

        $res = ApiResponse::getResponse(true, '', $company);

        $serializedData = $this->serializer->serialize($res, 'json', [
            'groups' => 'get',
        ]);

        return new JsonResponse($serializedData, 200, [], true);

    }
}
