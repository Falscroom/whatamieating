<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Shared\ValueObject\DriveId;
use Google\Client;
use Google\Service\Drive;
use Google\Service\Exception;
use GuzzleHttp\Psr7\Response;

final readonly class DriveDownloader
{
    public function __construct(
        private string $path,
        private Client $client,
    ) {}

    /** @throws Exception */
    public function download(DriveId $id): string
    {
        $service = new Drive($this->client);

        /** @var Response $response */
        $response = $service->files->get((string) $id, ['alt' => 'media']);
        $content = $response->getBody()->getContents();

        $filename = '/spreadsheet_' . $id . '.xlsx';
        $fullPath = $this->path . $filename;

        if (!file_put_contents($fullPath, $content)) {
            throw new Exception('Unable to write file');
        }

        return $fullPath;
    }
}
