<?php
declare(strict_types=1);

namespace App\Library\View;

class HtmlRenderer
{
    public static function render(string $view, array $data = []): void
    {
        extract($data);

        $path = __DIR__ . '/../Config/View/' . $view . '.php';

        if (!file_exists($path)) {
            throw new \Exception('View not found: ' . $view);
        }

        require $path;
    }
}