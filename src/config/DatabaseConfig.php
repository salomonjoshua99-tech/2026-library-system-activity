<?php

declare(strict_types=1);

namespace App\Library\Config;

/**
 * Database Configuration Constants
 *
 * Stores database connection parameters including host, username,
 * password, and database name for the library system.
 *
 * @author Joshua Salomon
 * @since 2026-05-08
 */
class DatabaseConfig
{
    public const HOST = 'localhost';
    public const USER = 'root';
    public const PASS = '';
    public const DB   = 'library_db';
}
