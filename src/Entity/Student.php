<?php

declare(strict_types=1);

namespace App\Library\Entity;

/**
 * Student Entity
 *
 * Represents a library member/student with personal information
 * and borrowing privileges.
 *
 * @author Joshua Salomon
 * @since 2026-05-08
 */
class Student
{
    /**
     * @var int|null The unique identifier for the student
     */
    public ?int $id = null;

    /**
     * @var string The full name of the student
     */
    public string $name;
}
