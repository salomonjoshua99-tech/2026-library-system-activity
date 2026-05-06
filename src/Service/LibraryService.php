<?php

declare(strict_types=1);

namespace App\Library;

use DateTime;

class LibraryService
{
    public const DAILY_FINE_RATE = 5.0;

    public function calculateFine(string $dueDate): float
    {
        $today = new DateTime();
        $due = new DateTime($dueDate);

        $diff = $today->diff($due)->format('%r%a');

        return ($diff < 0) ? abs((int)$diff) * self::DAILY_FINE_RATE : 0.0;
    }
}