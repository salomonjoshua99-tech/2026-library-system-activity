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
    public ?int $id = null;
    public string $name;
}
