<?php

namespace App\Controller\User;

use App\Enum\HttpCodes;
use App\Manager\UserManager;
use App\Services\Utils;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;

#[AsController]
class GetUserIdByIdentifier extends AbstractController
{
    public function __invoke(Request $request, UserManager $userManager): JsonResponse
    {
        $dataRequest = json_decode($request->getContent(), true);
        $user = $userManager->findUserByIdentifier($dataRequest['identifier']);

        if ($user === null) {
            return $this->json(
                Utils::formatErrorResponse("User not found", HttpCodes::USER_NOT_FOUND->value, $request->getContent()),
                HttpCodes::USER_NOT_FOUND->value
            );
        }

        return $this->json(['id' => $user->getId()]);
    }
}
