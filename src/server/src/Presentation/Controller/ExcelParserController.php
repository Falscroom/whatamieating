<?php

declare(strict_types=1);

namespace App\Presentation\Controller;

use App\Application\Service\DriveDownloader;
use App\Application\Service\ExcelParser;
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
    ) {}

    /** @throws Exception */
    #[Route(methods: ['POST'])]
    public function parse(#[MapRequestPayload] UrlDto $dto): JsonResponse
    {
        $path = $this->downloader->download(DriveId::fromUrl($dto->url));

        $this->parser->parse($path);

        //todo delete file?

        return new JsonResponse(Response::HTTP_CREATED);
    }
}
