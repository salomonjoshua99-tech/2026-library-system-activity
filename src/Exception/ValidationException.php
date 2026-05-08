<?php

declare(strict_types=1);

namespace App\Library\Exception;

/**
 * Validation Exception
 *
 * Custom exception for input validation errors including
 * invalid data formats and constraint violations.
 *
 * @author Juan Dela Cruz
 * @since 2026-05-08
 */

use Exception;

class ValidationException extends Exception {}
