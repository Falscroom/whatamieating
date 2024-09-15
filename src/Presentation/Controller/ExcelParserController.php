<?php

declare(strict_types=1);

namespace App\Presentation\Controller;

use App\Domain\Service\DriveDownloader;
use App\Domain\ValueObject\DriveId;
use App\Presentation\Dto\UrlDto;
use Google\Service\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class ExcelParserController extends AbstractController
{
    public function __construct(private DriveDownloader $downloader) {}

    /** @throws Exception */
    #[Route('/', methods: ['POST'])]
    public function parse(#[MapRequestPayload] UrlDto $dto): JsonResponse
    {
        $path = $this->downloader->download(DriveId::fromUrl($dto->url));

        return new JsonResponse([]);
    }
}
