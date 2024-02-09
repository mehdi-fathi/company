<?php

namespace App\Controller\User;

use App\Repository\UserRepository;
use App\Response\ApiResponse;
use App\Serializer\ApiResponseSerializer;
use App\Service\HelperService;
use App\Service\UserContextInterface;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;

#[AsController]
class ListUsers extends AbstractController
{

    public function __construct(
        private UserService          $userService,
        private SerializerInterface  $serializer,
        private UserContextInterface $userContext
    )
    {

    }

    public function __invoke(Request $request)
    {
        $page = max(1, $request->query->getInt('page', 0));

        $currentUser = $this->userContext->getCurrentUser();
        $users = $this->userService->paginateUsers(
            $currentUser->getRole(),
            $currentUser->getCompanyId(),
            $page,
        );

        $next = null;
        if ($users->count() > $page * UserRepository::PAGINATOR_PER_PAGE) {
            $next_page = $page + 1;
            $next = $this->generateUrl('get_user_list', ['page' => $next_page]);
        }

        if (empty($users->count())) {
            HelperService::notFoundException();
        }

        $res = ApiResponse::getResponse(
            success: true,
            data: $users,
            links: [
                'next' => $next
            ]
        );

        $serializedData = $this->serializer->serialize($res, 'json', [
            'groups' => 'get',
        ]);

        return new JsonResponse($serializedData, 200, [], true);

    }
}
