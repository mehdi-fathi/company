<?php

namespace App\Controller\Company;

use App\Repository\CompanyRepository;
use App\Response\ApiResponse;
use App\Serializer\ApiResponseSerializer;
use App\Service\CompanyService;
use App\Service\HelperService;
use App\Service\UserContextInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

#[AsController]
class ListCompanies extends AbstractController
{

    public function __construct(private CompanyService       $companyService,
                                private SerializerInterface  $serializer,
                                private UserContextInterface $userContext
    )
    {

    }

    public function __invoke(Request $request)
    {
        $page = max(1, $request->query->getInt('page', 0));

        $companies = $this->companyService->paginateCompanies(
            $page,
        );

        $next = null;
        if ($companies->count() > $page * CompanyRepository::PAGINATOR_PER_PAGE) {
            $next_page = $page + 1;
            $next = $this->generateUrl('get_companies_list', ['page' => $next_page]);
        }

        if (empty($companies->count())) {
            HelperService::notFoundException();
        }

        $res = ApiResponse::getResponse(
            true, '', $companies, null,
            [
                'next' => $next
            ]
        );

        $serializedData = $this->serializer->serialize($res, 'json', [
            'groups' => 'get',
        ]);

        return new JsonResponse($serializedData, 200, [], true);

    }
}
