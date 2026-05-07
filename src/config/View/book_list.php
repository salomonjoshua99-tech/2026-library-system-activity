<?php

declare(strict_types=1);

namespace App\Library\Config\View;
?>

<h2>Book List</h2>

<table border="1">
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Author</th>
    </tr>

    <?php foreach ($books as $book): ?>
        <tr>
            <td><?= $book['book_id'] ?></td>
            <td><?= $book['title'] ?></td>
            <td><?= $book['author'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>