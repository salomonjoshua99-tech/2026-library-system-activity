<?php
class HtmlRenderer {

    public static function renderBooks($books) {
        echo "<table border='1'>";
        echo "<tr><th>ID</th><th>Title</th><th>Author</th><th>Year</th><th>Genre</th></tr>";

        foreach ($books as $b) {
            echo "<tr>
                    <td>{$b['book_id']}</td>
                    <td>{$b['title']}</td>
                    <td>{$b['author']}</td>
                    <td>{$b['year']}</td>
                    <td>{$b['genre']}</td>
                  </tr>";
        }

        echo "</table>";
    }

    public static function renderReport($stats) {
        echo "<h2>Library Report</h2>";
        echo "<p>Total Books: {$stats['books']}</p>";
        echo "<p>Borrowed: {$stats['borrowed']}</p>";
        echo "<p>Returned: {$stats['returned']}</p>";
        echo "<p>Total Fines: {$stats['fines']}</p>";
    }
}
?>