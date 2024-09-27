<?php

declare(strict_types=1);

namespace App\Presentation\Controller;

use App\Application\Service\MealService;
use App\Domain\Entity\MealPlanning\User;
use App\Domain\Shared\ValueObject\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/meal')]
final class MealController extends AbstractController
{
    public function __construct(private readonly MealService $mealService) {}

    #[Route('/whatAmIEating', methods: ['GET'])]
    public function whatAmIEating(): JsonResponse
    {
        $user = new User('');
        $mealChoices = $this->mealService->getMealChoices($user, Date::today());

        return new JsonResponse($mealChoices->toArray());
    }
}
