<?php

declare(strict_types=1);

namespace App\Library\Config;

/**
 * Database Connection Manager
 *
 * Handles MySQL database connections using mysqli with proper
 * error handling and exception throwing for connection failures.
 *
 * @author Joshua Salomon
 * @since 2026-05-08
 */

use mysqli;
use App\Library\Exception\DatabaseException;

class DatabaseConnection
{
    /**
     * Establishes database connection using configuration constants.
     *
     * Creates MySQLi connection using DatabaseConfig parameters and
     * throws exception on connection failure.
     *
     * @return mysqli The established database connection
     * @throws DatabaseException If connection fails
     */
    public static function connect(): mysqli
    {
        $conn = new mysqli(
            DatabaseConfig::HOST,
            DatabaseConfig::USER,
            DatabaseConfig::PASS,
            DatabaseConfig::DB
        );

        if ($conn->connect_error) {
            throw new DatabaseException('Database connection failed');
        }

        return $conn;
    }
}
