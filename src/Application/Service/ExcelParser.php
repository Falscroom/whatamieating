<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Entity\MealPlanning\Meal;
use PhpOffice\PhpSpreadsheet\IOFactory;

final class ExcelParser
{
    /** @return Meal[] */
    public function parse(string $filePath): array
    {
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();

        $meals = [];

        return $meals;
    }
}
