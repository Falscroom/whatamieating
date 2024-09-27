<?php

declare(strict_types=1);

namespace App\Presentation\Controller;

use App\Application\Service\DriveDownloader;
use App\Application\Service\ExcelParser;
use App\Application\Service\MealService;
use App\Domain\Shared\ValueObject\DriveId;
use App\Presentation\Dto\UrlDto;
use Google\Service\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/parser')]
class ExcelParserController extends AbstractController
{
    public function __construct(
        private readonly DriveDownloader $downloader,
        private readonly ExcelParser $parser,
        private readonly MealService $mealService,
    ) {}

    /** @throws Exception */
    #[Route(methods: ['POST'])]
    public function parse(#[MapRequestPayload] UrlDto $dto): JsonResponse
    {
        $path = $this->downloader->download(DriveId::fromUrl($dto->url));

        $meals = $this->parser->parse($path);

        $this->mealService->saveMany($meals);

        return new JsonResponse(Response::HTTP_CREATED);
    }
}
