<?php

declare(strict_types=1);

namespace App\Presentation\Controller;

use Google\Client;
use Google\Service\Drive;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api')]
class TransactionsController extends AbstractController
{
    public function __construct(private Client $client) {}

    #[Route('/', methods: ['GET'])]
    public function countTransactions(): JsonResponse
    {
        $service = new Drive($this->client);
        $savePath = '/var/www/uploads/downloaded_file.xlsx';

        $response = $service->files->get($spreadsheetId, ['alt' => 'media']);

        $content = $response->getBody()->getContents();

        file_put_contents($savePath, $content);

        return new JsonResponse([]);
    }
}
