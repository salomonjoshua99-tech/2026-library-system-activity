<?php

declare(strict_types=1);

namespace App\Library\View;

/**
 * HTML Renderer
 *
 * Handles view rendering for the library system with support for
 * data extraction and template loading with proper error handling.
 *
 * @author Joshua Salomon
 * @since 2026-05-08
 */
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
