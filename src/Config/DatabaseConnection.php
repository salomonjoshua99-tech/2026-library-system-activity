<?php
declare(strict_types=1);

namespace App\Library\Config;

use mysqli;
use App\Library\Exception\DatabaseException;

class DatabaseConnection
{
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