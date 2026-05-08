<?php

declare(strict_types=1);

namespace App\Library\Config\View;
?>

<h2>Borrow Book</h2>

<form method="POST" action="/index.php?act=borrow">
    <label>Student ID:</label><br>
    <input type="number" name="sid" required><br><br>

    <label>Book ID:</label><br>
    <input type="number" name="bid" required><br><br>

    <label>Days:</label><br>
    <input type="number" name="days" required><br><br>

    <button type="submit">Borrow</button>
</form>