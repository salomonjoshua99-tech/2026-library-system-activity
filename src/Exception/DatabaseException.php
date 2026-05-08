<?php

declare(strict_types=1);

namespace App\Library\Exception;

/**
 * Database Exception
 *
 * Custom exception for database-related errors including
 * connection failures and query execution errors.
 *
 * @author Juan Dela Cruz
 * @since 2026-05-08
 */

use Exception;

class DatabaseException extends Exception {}
