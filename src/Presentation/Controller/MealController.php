<?php

declare(strict_types=1);

namespace App\Presentation\Controller;

use App\Application\Service\MealService;
use App\Domain\Entity\MealPlanning\User;
use App\Domain\Shared\ValueObject\Date;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api/meal')]
final class MealController extends AbstractController
{
    public function __construct(private readonly MealService $mealService) {}

    #[Route('/whatAmIEating', methods: ['GET'])]
    public function whatAmIEating(#[CurrentUser] User $user): Response
    {
        $mealChoices = $this->mealService->getMealChoices($user, Date::today());

        return $this->render('vue/index.html.twig', [
            'mealsData' => json_encode($mealChoices->toArray()),
        ]);
    }
}
