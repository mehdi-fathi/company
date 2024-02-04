<?php

namespace App\Controller;

use App\Dto\createUserDTO;
use App\Service\UserContextInterface;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Serializer\SerializerInterface;


#[AsController]
class CreateUser extends AbstractController
{

    public function __construct(
        private UserService          $userService,
        private SerializerInterface  $serializer,
        private UserContextInterface $userContext,
    )
    {
    }

    /**
     */
    public function __invoke(Request $request): JsonResponse
    {

        // Deserialize the incoming data into the DTO
        $dataDto = $this->deserializeJson($request->getContent(), createUserDTO::class);

        $this->userService->save(
            name: $dataDto->name,
            companyId: $dataDto->companyId,
            role: $dataDto->role,
        );

        return new JsonResponse($dataDto, Response::HTTP_CREATED);

    }


    private function deserializeJson(string $data, string $class): createUserDTO
    {
        return $this->serializer->deserialize($data, $class, 'json');
    }
}
